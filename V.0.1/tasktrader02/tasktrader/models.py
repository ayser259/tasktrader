from django.db import models

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
