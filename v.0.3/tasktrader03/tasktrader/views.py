from django.shortcuts import render, redirect
from django.template import loader
from . models import *
from django.http import HttpResponse, HttpResponseRedirect, JsonResponse
import requests
import datetime
import json
import requests
from django.core.exceptions import ObjectDoesNotExist
from . models import *
from django.views.decorators.csrf import csrf_exempt
from django.urls import reverse
from django.shortcuts import render, redirect
from django.template import loader
import random
from random import randint, choice
from django.http import HttpResponse, HttpResponseRedirect, JsonResponse
import sys

# Views to access webpages created
def index(request):
    return render(request, 'tasktrader/login.html')
    """
    This view is used to load the "applied.html" page
    Return a JSON response for the edited form or load the edit form page
    """
    return HttpResponse("Hello, world. You're at the tasktrader index.")

# method to log in users to the webpage
def login(request):
    try:
        print("Accessed login")
        if request.method == 'POST':
            print("")
            post_dict = request.POST
            print(post_dict)
            if post_dict['username']!="" and post_dict['password']!= "":
                employee_signing_in = Account(user)
                Employee(first_name=post_dict['first_name'])

                new_employee = Employee(username=post_dict['username'])
                new_employee.password = post_dict['password']

                account_set = Account.objects.all()
                proceed = False
                for account in account_set:
                    if account.username == new_employee.username and account.password == new_employee.password:
                        proceed = True
                if proceed:
                    currentuser = new_employee.owner
                    context = {'currentuser':currentuser}
                    return render(request, 'tasktrader/dashboard.html',context)
                else:
                    return HttpResponse("Access Denied")
                return HttpResponse("New Employee and Account Created")
            else:
                return HttpResponse("Something went wrong...(login)")
            return HttpResponse("Something went wrong...(login)")
        else:
            print("Retreiving login page...")
            return render(request, 'tasktrader/login.html')
    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
        return HttpResponse("Something went wrong...(add new employee)")
    except ValueError:
        print("Could not convert data to an integer.")
        return HttpResponse("Something went wrong...(add new employee)")
    except:
        print("Unexpected error:", sys.exc_info()[0])
        return HttpResponse("Something went wrong...(add new employee)")
    else:
        print('Something went wrong...')
        return HttpResponse("Something went wrong... (add new employee)")

# method to onboard new entities onto the platform
def onboarding(request):
    print("Accessing oboarding method...")
    print(request)
    try:
        company_set = Company.objects.all()
        location_set = Location.objects.all()
        department_set = Department.objects.all()
        context = {'company_set':company_set,'location_set':location_set,'department_set':department_set}
        return render(request, 'tasktrader/onboarding.html', context)
    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
        return HttpResponse("Something went wrong...(onboarding)")
    except ValueError:
        print("Could not convert data to an integer.")
        return HttpResponse("Something went wrong...(onboarding)")
    except:
        print("Unexpected error:", sys.exc_info()[0])
        return HttpResponse("Something went wrong...(onboarding)")
    else:
        print('Something went wrong...(onboarding)')

# Method to create new companies through the onboarding page
def add_new_company(request):
    try:
        print("Accessed add_new_company..")
        if request.method == 'POST':
            print("Adding new company...")
            post_dict = request.POST
            print(post_dict)
            if post_dict['company_name']!="" :
                all_companies = Company.objects.all()
                add_new = True
                company_name_to_add = post_dict['company_name']
                company_name_to_add = company_name_to_add.upper()
                for company in all_companies:
                    if company.company_name == company_name_to_add:
                        print("Company Name already exists")
                        add_new = False
                        return HttpResponse("Company Name Already Exists")
                if add_new:
                        new_company = Company(company_name=company_name_to_add)
                        new_company.save()
                        return HttpResponse("New Company Created")
                return HttpResponse("Something went wrong...(add new comp)")
        return HttpResponse("Something went wrong...")
    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
        return HttpResponse("Something went wrong...(add new comp)")
    except ValueError:
        print("Could not convert data to an integer.")
        return HttpResponse("Something went wrong...(add new comp)")
    except:
        print("Unexpected error:", sys.exc_info()[0])
        return HttpResponse("Something went wrong...(add new comp)")
    else:
        print('Something went wrong...')
        return HttpResponse("Something went wrong...(add new comp)")

# method to create new locations for companies throught the onboarding page
def add_new_location(request):
    try:
        print("Accessed add_new_location..")
        if request.method == 'POST':
            print("Adding new location...")
            post_dict = request.POST
            print(post_dict)
            if post_dict['campus_name']!="" and post_dict['new_location_company_id']!= "" and post_dict['city']!="" and post_dict['country']!="" and post_dict['street_address']!="" and post_dict['postal_code']!="" :
                all_locations = Location.objects.all()
                add_new= True
                campus_name = post_dict['campus_name']
                campus_name= campus_name.upper()
                location_company_id = int(post_dict['new_location_company_id'])
                for location in all_locations:
                    if location.campus_name == campus_name and location.company_id.id == location_company_id:
                        add_new = False
                        return HttpResponse("Location Already Exists")
                if add_new:
                        new_location = Location(campus_name=campus_name)
                        new_location.company_id = Company.objects.get(id = location_company_id)
                        new_location.city = post_dict['city']
                        new_location.country =post_dict['country']
                        new_location.street_address = post_dict['street_address']
                        new_location.postal_code = post_dict['postal_code']
                        new_location.save()
                        return HttpResponse("New Location Created")
                return HttpResponse("Something went wrong...(add new loc)")
            return HttpResponse("Something went wrong...(add new loc)")
        return HttpResponse("Something went wrong...(add new loc)")
    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
        return HttpResponse("Something went wrong...(add new loc)")
    except ValueError:
        print("Could not convert data to an integer.")
        return HttpResponse("Something went wrong...(add new loc)")
    except:
        print("Unexpected error:", sys.exc_info()[0])
        return HttpResponse("Something went wrong...(add new loc)")
    else:
        print('Something went wrong...')
        return HttpResponse("Something went wrong...(add new loc)")

# method to create new departments through the onboading page
def add_new_department(request):
    try:
        print("Accessed add_new_department..")
        if request.method == 'POST':
            print("Adding new department...")
            post_dict = request.POST
            print(post_dict)
            if post_dict['department_name']!="" and post_dict['new_department_company_id']!= "":
                all_departments = Department.objects.all()
                add_new= True
                department_name = post_dict['department_name']
                department_name= department_name.upper()
                department_company_id = int(post_dict['new_department_company_id'])
                for department in all_departments:
                    if department.department_name == department_name and department.company_id.id == department_company_id:
                        add_new = False
                        return HttpResponse("Department Already Exists")
                if add_new:
                    new_department = Department(department_name= department_name)
                    new_department.company_id =Company.objects.get(id = department_company_id)
                    new_department.save()
                    return HttpResponse("New Department Created")
                return HttpResponse("Something went wrong...(add new dept)")
            return HttpResponse("Something went wrong...(add new dept)")
        return HttpResponse("Something went wrong...(add new dept)")

    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
        return HttpResponse("Something went wrong...(add new dept)")
    except ValueError:
        print("Could not convert data to an integer.")
        return HttpResponse("Something went wrong...(add new dept)")
    except:
        print("Unexpected error:", sys.exc_info()[0])
        return HttpResponse("Something went wrong...(add new dept)")
    else:
        print('Something went wrong...')
        return HttpResponse("Something went wrong...(add new dept)")

# method to create new skills through the onboading page
def add_new_skill(request):
    try:
        print("Accessed add_new_skills..")
        if request.method == 'POST':
            print("Adding new skill...")
            post_dict = request.POST
            print(post_dict)
            if post_dict['skill']!="":
                all_skills = Skill.objects.all()
                add_new = True
                skill = post_dict['skill']
                skill = skill.upper()
                for item in all_skills :
                    if skill == item.skill_name:
                        add_new = False
                if add_new:
                    new_skill = Skill(skill_name = skill)
                    new_skill.save()
                    return HttpResponse("New Skill Created")
                else:
                    return HttpResponse("Skill Already Exists")
                return HttpResponse("Something went wrong...(add new dept)")
            return HttpResponse("Something went wrong...(add new dept)")
        return HttpResponse("Something went wrong...(add new dept)")
    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
        return HttpResponse("Something went wrong...(add new dept)")
    except ValueError:
        print("Could not convert data to an integer.")
        return HttpResponse("Something went wrong...(add new dept)")
    except:
        print("Unexpected error:", sys.exc_info()[0])
        return HttpResponse("Something went wrong...(add new dept)")
    else:
        print('Something went wrong...')
        return HttpResponse("Something went wrong...(add new dept)")

# method to create new employees through the onboading page
def add_new_employee(request):
    try:
        print("Accessed add_new_employee..")
        if request.method == 'POST':
            print("Adding new employee...")
            post_dict = request.POST
            print(post_dict)
            if post_dict['first_name']!="" and post_dict['last_name']!= "" and post_dict['new_employee_company_id']!="" and post_dict['new_employee_location_id']!="" and post_dict['new_employee_department_id']!="" and post_dict['job_title']!="" :
                new_employee = Employee(first_name=post_dict['first_name'])
                new_employee.last_name = post_dict['last_name']
                new_employee.job_title = post_dict['job_title']
                new_employee.location = Location.objects.get(id = int(post_dict['new_employee_location_id']))
                new_employee.department = Department.objects.get(id = int(post_dict['new_employee_department_id']))
                new_employee.save()

                new_employee_account =Account(owner = new_employee)
                new_employee_account.username = str(new_employee.first_name)+"."+str(new_employee.last_name)
                new_employee_account.password = str("tasktrader")
                new_employee_account.save()

                return HttpResponse("New Employee and Account Created")
            else:
                return HttpResponse("Something went wrong...(add new employee)")
            return HttpResponse("Something went wrong...(add new employee)")

    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
        return HttpResponse("Something went wrong...(add new employee)")
    except ValueError:
        print("Could not convert data to an integer.")
        return HttpResponse("Something went wrong...(add new employee)")
    except:
        print("Unexpected error:", sys.exc_info()[0])
        return HttpResponse("Something went wrong...(add new employee)")
    else:
        print('Something went wrong...')
        return HttpResponse("Something went wrong... (add new employee)")


def applied(request):
    return render(request, 'tasktrader/applied.html')

def create(request):
    try:
        print("Accessed create..")
        if request.method == 'POST':
            print("Adding new task...")
            post_dict = request.POST
            print(post_dict)

            if post_dict['skill']!="" :
                skill_list = post_dict['skill']
                print(skill_list)
                for skill in skill_list:
                    print('This is a new skill')
                    print(int(skill))

            if post_dict['task_title']!="" and post_dict['task_description']!= "" and post_dict['start_date']!="" and post_dict['end_date']!="" and post_dict['time_commitment']!="" and post_dict['new_task_location_id']!="" and post_dict['new_task_department_id']!="" :

                new_task = Task(task_title=post_dict['task_title'])
                new_task.task_description = post_dict['task_description']
                new_task.start_date = datetime.strptime(str(post_dict['start_date']), '%Y-%m-%d').date()
                new_task.end_date = datetime.strptime(str(post_dict['end_date']), '%Y-%m-%d').date()
                new_task.time_commitment = int(post_dict['time_commitment'])
                new_task.location = Location.objects.get(id=int(post_dict['new_task_location_id']))
                new_task.department = Department.objects.get(id=int(post_dict['new_task_department_id']))
                new_task.status = Status.objects.get(id = 1)
                new_task.save()
                new_posted_task = Posted_Task()
                new_posted_task.task_id = Task.objects.get(id=int(new_task.id))
                new_posted_task.employee_id = Employee.objects.get(id=1)
                new_posted_task.save()

                return HttpResponse("New Task Created")
            else:
                return HttpResponse("Something went wrong...(create) 1")
        else:
            company_set = Company.objects.all()
            location_set = Location.objects.all()
            department_set = Department.objects.all()
            skill_set = Skill.objects.all()
            context = {'company_set':company_set,'location_set':location_set,'department_set':department_set,'skill_set':skill_set}
            return render(request, 'tasktrader/create.html',context)
    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
        return HttpResponse("Something went wrong...(create)")
    except ValueError:
        print("Could not convert data to an integer.")
        return HttpResponse("Something went wrong...create) 2")
    except:
        print("Unexpected error:", sys.exc_info()[0])
        return HttpResponse("Something went wrong...create) 3")
    else:
        print('Something went wrong...')
        return HttpResponse("Something went wrong...create) 4")

def dashboard(request):
    return render(request, 'tasktrader/dashboard.html')

def explore(request):
    print('exploreing')
    programs = ["PYTHON","SQL",'R','PHOTOSHOP','VBA','JAVA','C#','PHOTOGRAPHY','EXCEL',
                'POWERPOINT','PREZI','PHOTO-EDITING','VIDEO-EDITING','PAINTING','FINANCIAL ANALYSIS','PROGRAMMING','ALGORITHMS',
                'SUMMARIZATION','PROOF READING']

    PREFIX = ['HELP WITH ', 'NEED EXPERT IN  ',' URGENT HELP IN  ','EXPERT HELP NEEDED IN ','ASSISTANCE REQUIRED WITH ','GUIDANCE NEEDED WITH ','LARGE PROJECT : NEED HELP WITH ']
    SUFFIX = [' HELP NEEDED',' TASK NEEDED FOR DEPARTMENT PROJECT',' TASK AVAILABLE',' TUTOROIALS REQUIRED']
    DEPARTMENT = ['CORPORTATE STRATEGY PROJECT','PRODUCT DEVELOPMENT PROJECT','MARKETING PROJECT','ADVERTISING PROJECT','INSTAGRAM PROJECT','WHATSAPP PROJECT','OCULUS PROJECT']
    res = []
    for item in programs:
        for pre in PREFIX:
            res.append(pre+item)
        for suf in SUFFIX:
            res.append(item+suf)
        for dep in DEPARTMENT:
            res.append(dep)
    print('res is')
    print(len(res))

    year_range = [str(i) for i in range(1900, 2014)]
    month_range = ["01","02","03","04","05","06","07","08","09","10","11","12"]
    day_range = [str(i).zfill(2) for i in range(1,28)]
    num_range = ["11","10","9","8","7","6"]
    emp_range = ["2","3","4","5","6","7"]

    for re in res:
        print(123)
        print(re)
        new_task = Task()
        new_task.task_title = re
        new_task.task_description ="rem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book."
        date_1 = (random.choice(year_range)+'-'+random.choice(month_range)+'-'+random.choice(day_range))
        date_2 = (random.choice(year_range)+'-'+random.choice(month_range)+'-'+random.choice(day_range))
        new_task.start_date = datetime.strptime(str(date_1), '%Y-%m-%d').date()
        new_task.end_date = datetime.strptime(str(date_2), '%Y-%m-%d').date()
        new_task.time_commitment = random.choice(day_range)
        new_task.location = Location.objects.get(id=int(random.choice(num_range)))
        new_task.department = Department.objects.get(id = int(random.choice(num_range)))
        new_task.status = Status.objects.get(id = 1)
        new_task.save()

        new_posted_task = Posted_Task()
        new_posted_task.task_id = Task.objects.get(id=int(new_task.id))
        new_posted_task.employee_id = Employee.objects.get(id=int(random.choice(emp_range)))
        new_posted_task.save()

        new_task_skill = Task_Skills()
        new_task_skill.task_id = new_task
        new_task_skill.skill_id = Skill.objects.get(id=int(random.choice(emp_range)))
        new_task_skill.save()
            # Data generation code for tasks is below
    return HttpResponse('Data Generated')

def insert_task(request):
    return render(request, 'tasktrader/insert_task.html')

def nav(request):
    return render(request, 'tasktrader/nav.html')

def profile(request):
    return render(request, 'tasktrader/profile.html')

def taskresult(request):
    return render(request, 'tasktrader/taskresult.html')

def tasks(request):
    try:
        print("Accessed tasks..")

        if request.method == 'POST':
            print("searching tasks...")
            post_dict = request.POST
            print(post_dict)
            print('AA')
            current_employee = Employee.objects.get(id=1)
            company = Company.objects.filter(id=int(current_employee.location.company_id.id))
            location_set = Location.objects.filter(company_id__in=company)
            task_set = Task.objects.filter(location__in= location_set)
            department_set = Department.objects.filter(company_id__in=company)

            dep = post_dict['task_department_id']
            loc = post_dict['task_location_id']
            com = post_dict['time_commitment']
            print('com is')
            print(com)
            print('dep is')
            print(dep)
            print('loc is')
            print(loc)

            dont_skip_dep = True
            dont_skip_loc = True

            if dep == 'ALL':
                print('YES dep is All')
                dont_skip_dep = False
            if loc =='ALL':
                print('YES loc is All')
                dont_skip_loc = False

            if dont_skip_dep==True:
                if  post_dict['task_department_id']!="" and isinstance(int(dep),int):
                    department_set = department_set.filter(id= int(dep))
                    print('cc')
                    task_set = task_set.filter(department__in=department_set)
            if dont_skip_loc==True:
                if post_dict['task_location_id']!="" and isinstance(int(loc),int):
                    location_set = location_set.filter(id = int(loc))
                    task_set = task_set.filter(location__in=location_set)
            if  post_dict['time_commitment']!="" and isinstance(int(com),int):
                task_set = task_set.filter(time_commitment = int(com))
            context = {'task_set':task_set,'location_set':location_set,'department_set':department_set}
            return render(request, 'tasktrader/tasks.html',context)
        else:
            current_employee = Employee.objects.get(id=1)
            company = Company.objects.filter(id=int(current_employee.location.company_id.id))
            location_set = Location.objects.filter(company_id__in=company)
            task_set = Task.objects.filter(location__in= location_set)
            department_set = Department.objects.filter(company_id__in=company)
            context = {'task_set':task_set,'location_set':location_set,'department_set':department_set}
            return render(request, 'tasktrader/tasks.html',context)

    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
        return HttpResponse("Something went wrong...(tasks) 1")
    except ValueError:
        print("Could not convert data to an integer.")
        return HttpResponse("Something went wrong...(tasks) 2")
    except:
        print("Unexpected error:", sys.exc_info()[0])
        return HttpResponse("Something went wrong...(tasks) 3")
    else:
        print('Something went wrong...')
        return HttpResponse("Something went wrong...(tasks) 4")
