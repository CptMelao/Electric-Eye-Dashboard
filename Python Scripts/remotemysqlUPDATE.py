import mysql.connector
import platform
import psutil
import GPUtil
import subprocess
import string
import random
import cpuinfo
import netifaces
import wmi
import ctypes
import locale
import time
from getmac import get_mac_address as gma
from datetime import datetime

def convert_bytes(bytes, suffix="B"):
    factor = 1024
    for unit in ["", "K", "M", "G", "T", "P"]:
        if bytes < factor:
            return f"{bytes:.2f}{unit}{suffix}"
        bytes /= factor


mydb = mysql.connector.connect(host='remotemysql.com',
                               database='akG9Dvp8mp',
                               port='3306',
                               user='akG9Dvp8mp',
                               password='daQAeSuxgJ')

mycursor = mydb.cursor()

while True:
    time.sleep(5)

    motherboard_id = subprocess.check_output('wmic csproduct get uuid').decode().split('\n')[1].strip()

    # System Info Update
    windll = ctypes.windll.kernel32
    windll.GetUserDefaultUILanguage()

    lang = locale.windows_locale[windll.GetUserDefaultUILanguage()]
    uname = platform.uname()

    sys_sql = "UPDATE `system_info` SET `system`= %s,`node_name`= %s,`os_release`= %s,`version`= %s,`machine`= %s, `system_language`= %s, `processor`= %s"
    sys_val = (uname.system, uname.node, uname.release, uname.version, uname.machine, lang, uname.processor)
    mycursor.execute(sys_sql, sys_val)


    # Boot Info Update
    boot_time_timestamp = psutil.boot_time()
    bt = datetime.fromtimestamp(boot_time_timestamp)

    boot_sql = "UPDATE `boot_info` SET `day`= %s, `month`= %s, `year`= %s, `hour`= %s, `minute`= %s, `second`= %s"
    boot_val = (bt.day, bt.month, bt.year, bt.hour, bt.minute, bt.second,)
    mycursor.execute(boot_sql, boot_val)


    # CPU Info Update
    pC = psutil.cpu_count(logical=False)
    tC = psutil.cpu_count(logical=True)
    fab = cpuinfo.get_cpu_info()['brand_raw']
    cpufreq = psutil.cpu_freq()

    cpu_sql = "UPDATE `cpu_info` SET `cpu_name`= %s, `physical_cores`= %s, `total_cores`= %s, `cpu_freq_max`= %s, `cpu_freq_min`= %s, `cpu_freq_current`= %s"
    cpu_val = (fab, pC, tC, cpufreq.max, cpufreq.min, cpufreq.current)
    mycursor.execute(cpu_sql, cpu_val)


    # Memory Info Update
    svmem = psutil.virtual_memory()

    mem_sql = "UPDATE `memory_info` SET `mem_total`= %s, `mem_available`= %s, `mem_used`= %s, `mem_used_percent`= %s"
    mem_val = (convert_bytes(svmem.total), convert_bytes(svmem.available), convert_bytes(svmem.used), svmem.percent)
    mycursor.execute(mem_sql, mem_val)


    # Disk Info Update
    partitions = psutil.disk_partitions()
    disk_io = psutil.disk_io_counters()

    for partition in partitions:
        partitions = psutil.disk_partitions()
        partition_usage = psutil.disk_usage(partition.mountpoint)
        disk_1_sql = "UPDATE `disk_info` SET `mountpoint`= %s, `file_type`= %s, `total_size`= %s, " \
                     "`total_used`= %s, `total_free`= %s, `used_percentage`= %s"
        disk_1_val = (partition.mountpoint, partition.fstype, convert_bytes(partition_usage.total),
                      convert_bytes(partition_usage.used), convert_bytes(partition_usage.free), partition_usage.percent)
        mycursor.execute(disk_1_sql, disk_1_val)


    # Network Info Update
    net_io = psutil.net_io_counters()
    for iface in netifaces.interfaces():
        iface_details = netifaces.ifaddresses(iface)
        if netifaces.AF_INET in iface_details:
            for ip_interfaces in iface_details[netifaces.AF_INET]:
                for key, ip_add in ip_interfaces.items():
                    if key == 'addr' and ip_add != '127.0.0.1':
                        net_sql = "UPDATE `network_info` SET `if_name`= %s, `ip_address`= %s, `mac_address`= %s, `total_sent`= %s, `total_received`= %s"
                        net_val = (key, ip_add, gma(), convert_bytes(net_io.bytes_sent), convert_bytes(net_io.bytes_recv))
                        mycursor.execute(net_sql, net_val)


    # GPU Info Update
    gpus = GPUtil.getGPUs()
    for gpu in gpus:
        gpu_sql = "UPDATE `gpu_info` SET `gpu_id`= %s, `gpu_name`= %s, `gpu_load`= %s, `gpu_free_memory`= %s, `gpu_used_memory`= %s," \
                  "`gpu_total_memory`= %s, `gpu_temperature`= %s"
        gpu_val = (gpu.id, gpu.name, gpu.load, convert_bytes(gpu.memoryFree), convert_bytes(gpu.memoryUsed),
                   convert_bytes(gpu.memoryTotal), gpu.temperature)
        mycursor.execute(gpu_sql, gpu_val)

    mydb.commit()

    print(mycursor.rowcount, "inserido.")
