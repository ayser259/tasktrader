from django.contrib import admin

# Register your models here.
from .models import *
admin.site.register(Company)
admin.site.register(Location)
admin.site.register(Department)
admin.site.register(Employee)
admin.site.register(Account)
admin.site.register(Status)
admin.site.register(Task)
admin.site.register(CV)
admin.site.register(Picture)
admin.site.register(Skill)
admin.site.register(Task_Skills)
admin.site.register(Posted_Task)
admin.site.register(Applied_Task)
admin.site.register(Filled_Task)
admin.site.register(Random_Task)
admin.site.register(Current_User)
