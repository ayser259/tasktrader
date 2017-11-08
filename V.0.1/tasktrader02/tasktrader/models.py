from django.db import models
from datetime import datetime

# Models representing objects that will make up tasktrader

class Company(models.Model):
    id = models.AutoField(primary_key =True)
    company_name = models.CharField(max_length = 30)

    def __str__(self): # returns the string value for the company name and company ID
        return_value = (self.id + " , " +str(self.company_name))
        return return_value

class Location(models.Model):
    id = models.AutoField(primary_key=True)
    campus_name = models.CharField(max_length=30)
    city = models.CharField(max_length=30)
    country = models.CharField(max_length=30)
    street_address = models.CharField(max_length=30)
    postal_code = models.CharField(max_length=30)

    def __str__(self): # returns the string value for the Location
        return_value = (self.id + " , " +str(self.campus_name)+ " , " +str(self.city)+ " , " +str(self.country)+ " , " +str(self.street_address)+ " , " +str(self.postal_code))
        return return_value

class Department(models.Model):
    id = models.AutoField(primary_key = True)
    company_id = models.ForeignKey(Company, on_delete=models.CASCADE)
    department_name = models.CharField(max_length=30)

    def __str__(self): # returns the string value for the Location
        return_value = (self.id + " , " +str(self.company_id.company_name)+ " , " +str(self.department_name))
        return return_value

class Employee(models.Model):
    id = models.AutoField(primary_key=True)
    job_title = models.CharField(max_length=20)
    first_name = models.CharField(max_length=20)
    last_name = models.CharField(max_length=20)
    location = models.ForeignKey(Location,on_delete=models.CASCADE)
    department = models.ForeignKey(Department, on_delete= models.CASCADE)
    supervisor = models.ForeignKey(Employee, on_delete = models.CASCADE)

class Account(models.Model):
    id = models.AutoField(primary_key=True)
    username = models.CharField(max_length=20)
    password = models.CharField(max_length=20)
    owner = models.ForeignKey(Employee, on_delete=models.CASCADE)

class Status(models.Model):
    id = models.AutoField(primary_key=True)
    status_type = models.CharField(max_length=20)

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
