from django.db import models
from datetime import datetime

# Models representing objects that will make up tasktrader

class Company(models.Model):
    id = models.AutoField(primary_key =True)
    company_name = models.CharField(max_length = 30)

    def __str__(self): # returns the string value for the company name and company ID
        return_value = (str(self.id) + " , " +str(self.company_name))
        return return_value

class Location(models.Model):
    id = models.AutoField(primary_key=True)
    campus_name = models.CharField(max_length=30)
    city = models.CharField(max_length=30)
    country = models.CharField(max_length=30)
    street_address = models.CharField(max_length=30)
    postal_code = models.CharField(max_length=30)

    def __str__(self): # returns the string value for the Location
        return_value = (str(self.id) + " , " +str(self.campus_name)+ " , " +str(self.city)+ " , " +str(self.country)+ " , " +str(self.street_address)+ " , " +str(self.postal_code))
        return return_value

class Department(models.Model):
    id = models.AutoField(primary_key = True)
    company_id = models.ForeignKey(Company, on_delete=models.CASCADE)
    department_name = models.CharField(max_length=30)

    def __str__(self): # returns the string value for the Location
        return_value = (str(self.id) + " , " +str(self.company_id.company_name)+ " , " +str(self.department_name))
        return return_value

class Employee(models.Model):
    id = models.AutoField(primary_key=True)
    job_title = models.CharField(max_length=20)
    first_name = models.CharField(max_length=20)
    last_name = models.CharField(max_length=20)
    location = models.ForeignKey(Location,on_delete=models.CASCADE)
    department = models.ForeignKey(Department, on_delete= models.CASCADE)
    supervisor = models.ForeignKey(Employee, on_delete = models.CASCADE)

    def __str__(self): # returns the string value for the Location
        return_value = (str(self.id) + " , " +str(self.first_name)+ " , "str(self.last_name)+ " , " +str(self.department.department_name)+" , "+str(self.location.campus_name))
        return return_value

class Account(models.Model):
    id = models.AutoField(primary_key=True)
    username = models.CharField(max_length=20)
    password = models.CharField(max_length=20)
    owner = models.ForeignKey(Employee, on_delete=models.CASCADE)

    def __str__(self):
        return_value = (str(self.id) + " , "+ str(self.username))
        return return_value

class Status(models.Model):
    id = models.AutoField(primary_key=True)
    status_type = models.CharField(max_length=20)

    def __str__(self):
        return_value = (str(self.id) + " , " + str(self.status_type))
        return return_value

class Task(models.Model):
    id = models.AutoField(primary_key=True)
    task_title =models.CharField(max_length=30)
    task_description = models.CharField(max_length = 50)
    end_date = models.DateField(null=true)
    start_date = models.DateField(null= true)
    time_commitment = models.DateTimeField(default = datetime.now, blank =True)
    location = models.ForeignKey(Location, on_delete = model.CASCADE)
    department = models.ForeignKey(Department, on_delete = models.CASCADE)
    status = models.ForeignKey(Status, on_delete = models.CASCADE)

    def  __str__(self):
        return_value = (str(self.id), + " , "+str(self.task_title) + ", "+ str(self.status.status_type)
        return return_value

class CV(models.model):
    id = models.AutoField(primary_key=True)
    employee - models.ForeignKey(Employee,on_delete = models.CASCADE)
    cv = models.FileField(upload_to='resumés')

    def __str__(self):
        return_value = (str(self.id) + " ,"+str(self.employee.first_name))
        return return_value


class Picture(models.model):
    id = models.AutoField(primary_key=True)
    employee - models.ForeignKey(Employee,on_delete = models.CASCADE)
    picture = models.ImageField(upload_to='Profile_Pictures')

    def __str__(self):
        return_value = (str(self.id) + " ,"+str(self.employee.first_name))
        return return_value

class Skill(models.model):
    id = models.AutoField(primary_key = True)
    skill_name = models.CharField(max_length = 20)

    def __str__(self):
        return_value = (str(self.id)+  " ,"+str(self.skill_name))
        return return_value

class Task_Skills(models.model):
    task_id = models.ForeignKey(Task, on_delete = models.CASCADE)
    skill_id = models.ForeignKey(Skill, on_delete = models.CASCADE)

    def __str__(self):
        return_value = (str(self.task_id.id)+  " ,"+str(self.skill_id.id))
        return return_value

class Employee_Skills(models.model):
    employee_id = models.ForeignKey(Employee, on_delete = models.CASCADE)
    skill_id = models.ForeignKey(Skill, on_delete = models.CASCADE)

    def __str__(self):
        return_value = ("employee :"+str(self.employee_id.id)+ ", skill: "+str(self.skill_id.id))
        return return_value

class Posted_Task(models.model):
    task_id = models.ForeignKey(Task, on_delete = models.CASCADE)
    employee_id = models.ForeignKey(Employee, on_delete = models.CASCADE)

    def __str__(self):
        return_value = ("employee: "+str(self.employee_id.id)+ ", Task: "+ str(self.task_id.id))
        return return_value

class Applied_Task(models.model):
    task_id = models.ForeignKey(Task, on_delete = models.CASCADE)
    employee_id = models.ForeignKey(Employee, on_delete = models.CASCADE)

    def __str__(self):
        return_value = ("employee: "+str(self.employee_id.id)+ ", Task: "+ str(self.task_id.id))
        return return_value

class Filled_Task(models.model):
    task_id = models.ForeignKey(Task, on_delete = models.CASCADE)
    employee_id = models.ForeignKey(Employee, on_delete = models.CASCADE)

    def __str__(self):
        return_value = ("employee: "+str(self.employee_id.id)+ ", Task: "+ str(self.task_id.id))
        return return_value
