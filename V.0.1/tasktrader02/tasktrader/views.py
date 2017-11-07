from django.shortcuts import render
from django.http import HttpResponse


# Views to access webpages created
def index(request):
    return HttpResponse("Hello, world. You're at the polls index.")
