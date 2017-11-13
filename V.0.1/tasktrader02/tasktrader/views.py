from django.shortcuts import render, redirect
from django.template import loader
from . models import *
from django.http import HttpResponse, HttpResponseRedirect, JsonResponse
import requests
import datetime
import json
from django.views.decorators.csrf import csrf_exempt
from django.urls import reverse
from django.core.exceptions import ObjectDoesNotExist

# Views to access webpages created
def index(request):
    """
    This view is used to load the "applied.html" page
    Return a JSON response for the edited form or load the edit form page
    """
    return HttpResponse("Hello, world. You're at the polls index.")

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
    return render(request, 'tasktrader/tasks.html')
