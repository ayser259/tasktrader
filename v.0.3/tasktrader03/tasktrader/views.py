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

# Create your views here.
def index(request):
    """
    This view is used to load the "applied.html" page
    Return a JSON response for the edited form or load the edit form page
    """
    return HttpResponse("Hello, world. You're at the tasktrader index.")
