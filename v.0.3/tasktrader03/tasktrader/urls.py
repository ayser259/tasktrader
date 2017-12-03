from django.conf.urls import url

from . import views

urlpatterns = [
# urls to access pages
    url(r'^$', views.index, name='index'),
]
