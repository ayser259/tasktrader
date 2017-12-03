from django.conf.urls import url

from . import views

urlpatterns = [
# urls to access pages
    url(r'^$', views.index, name='index'),
    url(r'applied', views.applied, name='applied'),
    url(r'create', views.create, name='create'),
    url(r'dashboard', views.dashboard, name='dashboard'),
    url(r'explore', views.explore, name='explore'),
    url(r'insert_task', views.insert_task, name='insert_task'),
    url(r'nav', views.nav, name='nav'),
    url(r'profile', views.profile, name='profile'),
    url(r'taskresult', views.taskresult, name='taskresult'),
    url(r'task', views.tasks, name='tasks'),
    url(r'onboarding', views.onboarding, name='onboarding'),
# urls to intereact with db
    url(r'add_new_company', views.add_new_company, name='add_new_company'),
]
