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
from django.http import HttpResponse, HttpResponseRedirect, JsonResponse
import sys

# Views to access webpages created
def index(request):
    """
    This view is used to load the "applied.html" page
    Return a JSON response for the edited form or load the edit form page
    """
    return HttpResponse("Hello, world. You're at the tasktrader index.")

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
    except ValueError:
        print("Could not convert data to an integer.")
    except:
        print("Unexpected error:", sys.exc_info()[0])
    else:
        print('Something went wrong...')

'''
                 # Loading all the Active questions for the current form; Questions can also have a 'deleted' status where they are no longer needed, but they have data in the DB tied to it
                 question_set = Question.objects.filter(parent_form=current_form)
                 question_set = question_set.filter(question_status = Status.objects.get(status='ACTIVE'))
                 option_set = Option.objects.filter(current_question__in=question_set)

                 question_type_set = Question_Type.objects.all()

                 # Loading Set of all plants in accordance to the user's privileges
                 if(current_user.user_privileges == User_Privileges.objects.get(user_privileges='FULL_ACCESS')) or (current_user.user_privileges == User_Privileges.objects.get(user_privileges='ADMIN')):
                    plant_set = Plant.objects.all()
                    plant_set = plant_set.filter(plant_status = Status.objects.get(status = "ACTIVE"))
                    context = {'current_form':current_form,'question_set':question_set,'option_set':option_set,'question_type_set':question_type_set,'plant_set':plant_set}
                    return HttpResponseRedirect(str(current_form.form_id)+'/edit_forms')
                 else:
                    given_plant =Plant.objects.get(plant_id=current_user.parent_plant.plant_id)
                    if authenticate(request, given_plant.plant_id):
                        plant_set = []
                        plant_set.append(given_plant)
                        print('Redirecting to Edit Forms Page')
                        request.method = 'GET'
                        context = {'current_form':current_form,'question_set':question_set,'option_set':option_set,'question_type_set':question_type_set,'plant_set':plant_set}
                        return HttpResponseRedirect(str(current_form.form_id)+'/edit_forms')
                    else:
                        return HttpResponse("User Does Not Have Appropriate Access Level for This Feature")
             else:
                return HttpResponse("User Does Not Have Appropriate Access Level for This Feature")
         else:
             # GET Method for create form
             # Loads set of all plants relevant to user's privileges
             return HttpResponse("No get method exist for this page -> Rory sucks - Ayser")
     else:
         return HttpResponse('User Does Not Have Access')
'''


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
                return HttpResponse("Something went wrong...")
    except ObjectDoesNotExist as e:
        print("There is no answer that exist the database: ", str(e))
    except ValueError:
        print("Could not convert data to an integer.")
    except:
        print("Unexpected error:", sys.exc_info()[0])
    else:
        print('Something went wrong...')

def applied(request):
    return render(request, 'tasktrader/applied.html')

def create(request):
    return render(request, 'tasktrader/create.html')

def dashboard(request):
    return render(request, 'tasktrader/dashboard.html')

def explore(request):
    return render(request, 'tasktrader/explore.html')

def insert_task(request):
    return render(request, 'tasktrader/insert_task.html')

def nav(request):
    return render(request, 'tasktrader/nav.html')

def profile(request):
    return render(request, 'tasktrader/profile.html')

def taskresult(request):
    return render(request, 'tasktrader/taskresult.html')

def tasks(request):
    print(hello)
    return render(request, 'tasktrader/tasks.html')
"""
        if request.method == 'POST':
            if(current_user.user_privileges == User_Privileges.objects.get(user_privileges='FULL_ACCESS')) or (current_user.user_privileges == User_Privileges.objects.get(user_privileges='ADMIN')):
                post_dict = request.POST
                print(post_dict)
                if post_dict['plant_name']!="" :
                    all_plants = Plant.objects.all()
                    all_lines = Line.objects.all()
                    all_skus = SKU.objects.all()
                    add_new = True
                    plant_to_add = post_dict['plant_name']
                    plant_name_to_add = plant_to_add.upper()
                    for plant in all_plants:
                        if plant.plant_name == plant_name_to_add:
                            print("Plant Name Already Exists...")
                            plant.plant_status = Status.objects.get(status='ACTIVE')
                            plant.save()
                            for line in all_lines:
                                if line.parent_plant == plant:
                                    line.line_status = Status.objects.get(status='ACTIVE')
                                    line.save()
                            for sku in all_skus:
                                if sku.parent_line.parent_plant == plant:
                                    sku.sku_status = Status.objects.get(status='ACTIVE')
                                    sku.save()
                            add_new = False
                            new_plant= plant
                            break
                    if add_new == True:
                        new_plant = Plant()
                        new_plant = Plant(plant_name=plant_name_to_add)
                        new_plant.plant_status = Status.objects.get(status='ACTIVE')
                        new_plant.save()
                        new_plant.plant_key = plant_name_to_plant_key(plant_name_to_add,new_plant.plant_id)
                        new_plant.save()
                    context = {"new_plant": new_plant.plant_name, "new_plant_id": new_plant.plant_id, "new_plant_key": new_plant.plant_key}
                    return JsonResponse(context)
                else:
                    return HttpResponse("Invalid Entry")
            else:
                return HttpResponse("User Does Not Have Access To This Function")
        else:
            return HttpResponse("Method Does Not Have A Get Method")
    else:
        HttpResponse("User Does Not Have Access")
"""
