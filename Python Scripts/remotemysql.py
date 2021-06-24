import mysql.connector
import platform
import psutil
import GPUtil
import subprocess
import string
import random
import cpuinfo
import netifaces
import ctypes
import locale
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


# Login Info
min = string.ascii_lowercase
mai = string.ascii_uppercase
num = string.digits

pw_soma = min + mai + num

pw_temp = random.sample(pw_soma, 10)

pw = "".join(pw_temp)

motherboard_id = subprocess.check_output('wmic csproduct get uuid').decode().split('\n')[1].strip()
username = subprocess.check_output('wmic csproduct get uuid').decode().split('-')[3].strip()

f = open("login.txt", "w")
f.write("Username: " + username)
f.write("\n")
f.write("Password: " + pw)
f.write("\n")
f.write("Serial: " + motherboard_id)

login_sql = "INSERT INTO `login` (`serial_global`, `username`, `password`, `type`) VALUES (%s, %s, %s, 'user')"
login_val = (motherboard_id, username, pw,)
mycursor.execute(login_sql, login_val)


# System Info
windll = ctypes.windll.kernel32
windll.GetUserDefaultUILanguage()

lang = locale.windows_locale[windll.GetUserDefaultUILanguage()]
uname = platform.uname()
sys_sql = "INSERT INTO `system_info` (`serial_system`, `system`, `node_name`," \
          " `os_release`, `version`, `machine`,  `system_language`, `processor`)" \
          "VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
sys_val = (motherboard_id, uname.system, uname.node, uname.release,
           uname.version, uname.machine, lang, uname.processor,)
mycursor.execute(sys_sql, sys_val)

# Boot Info
boot_time_timestamp = psutil.boot_time()
bt = datetime.fromtimestamp(boot_time_timestamp)

boot_sql = "INSERT INTO `boot_info` (`serial_boot`, `day`, `month`, `year`," \
           " `hour`, `minute`, `second`)" \
           "VALUES (%s, %s, %s, %s, %s, %s, %s)"
boot_val = (motherboard_id, bt.day, bt.month, bt.year, bt.hour, bt.minute, bt.second,)
mycursor.execute(boot_sql, boot_val)


# CPU Info
pC = psutil.cpu_count(logical=False)
tC = psutil.cpu_count(logical=True)
fab = cpuinfo.get_cpu_info()['brand_raw']

cpufreq = psutil.cpu_freq()

cpu_sql = "INSERT INTO `cpu_info` (`serial_cpu`, `cpu_name`,`physical_cores`," \
          " `total_cores`, `cpu_freq_max`,`cpu_freq_min`, `cpu_freq_current`)" \
          "VALUES (%s, %s, %s, %s, %s, %s, %s)"
cpu_val = (motherboard_id, fab, pC, tC, cpufreq.max, cpufreq.min, cpufreq.current)
mycursor.execute(cpu_sql, cpu_val)


# Memory Info
svmem = psutil.virtual_memory()

mem_sql = "INSERT INTO `memory_info` (`serial_memory`, `mem_total`, `mem_available`," \
          " `mem_used`, `mem_used_percent`)" \
          "VALUES (%s, %s, %s, %s, %s)"
mem_val = (motherboard_id, convert_bytes(svmem.total), convert_bytes(svmem.available),
           convert_bytes(svmem.used), svmem.percent)
mycursor.execute(mem_sql, mem_val)


# Disk Info
partitions = psutil.disk_partitions()
disk_io = psutil.disk_io_counters()

for partition in partitions:
    motherboard_id = subprocess.check_output('wmic csproduct get uuid').decode().split('\n')[1].strip()
    partition_usage = psutil.disk_usage(partition.mountpoint)
    disk_1_sql = "INSERT INTO `disk_info` (`serial_disk`, `mountpoint`, `file_type`," \
                " `total_size`, `total_used`, `total_free`, `used_percentage`)" \
                 "VALUES (%s, %s, %s, %s, %s, %s, %s)"
    disk_1_val = (motherboard_id, partition.mountpoint, partition.fstype,
                  convert_bytes(partition_usage.total), convert_bytes(partition_usage.used),
                  convert_bytes(partition_usage.free), partition_usage.percent)
    mycursor.execute(disk_1_sql, disk_1_val)


# Network Info
net_io = psutil.net_io_counters()
for iface in netifaces.interfaces():
    iface_details = netifaces.ifaddresses(iface)
    if netifaces.AF_INET in iface_details:
        for ip_interfaces in iface_details[netifaces.AF_INET]:
            for key, ip_add in ip_interfaces.items():
                if key == 'addr' and ip_add != '127.0.0.1':
                    net_sql = "INSERT INTO `network_info` (`serial_network`, `if_name`," \
                              " `ip_address`, `mac_address`, `total_sent`, `total_received`)" \
                              "VALUES (%s, %s, %s, %s, %s, %s)"
                    net_val = (motherboard_id, key, ip_add, gma(),
                               convert_bytes(net_io.bytes_sent), convert_bytes(net_io.bytes_recv))
                    mycursor.execute(net_sql, net_val)


# GPU Info
gpus = GPUtil.getGPUs()
for gpu in gpus:
    gpu_sql = "INSERT INTO `gpu_info` (`serial_gpu`, `gpu_id`, `gpu_name`," \
              " `gpu_load`, `gpu_free_memory`,`gpu_used_memory`, " \
              "`gpu_total_memory`, `gpu_temperature`) " \
              "VALUES (%s, %s, %s, %s, %s, %s, %s, %s)"
    gpu_val = (motherboard_id, gpu.id, gpu.name, gpu.load,
               gpu.memoryFree, gpu.memoryUsed, gpu.memoryTotal, gpu.temperature)
    mycursor.execute(gpu_sql, gpu_val)


mydb.commit()

print(mycursor.rowcount, "inserido.")

exec(open('remotemysqlUPDATE.py').read())
