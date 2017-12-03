# -*- coding: utf-8 -*-
# Generated by Django 1.11.7 on 2017-12-03 03:01
from __future__ import unicode_literals

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('tasktrader', '0011_auto_20171203_0258'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='account',
            name='owner',
        ),
        migrations.RemoveField(
            model_name='applied_task',
            name='employee_id',
        ),
        migrations.RemoveField(
            model_name='applied_task',
            name='task_id',
        ),
        migrations.RemoveField(
            model_name='cv',
            name='employee',
        ),
        migrations.RemoveField(
            model_name='department',
            name='company_id',
        ),
        migrations.RemoveField(
            model_name='employee',
            name='department',
        ),
        migrations.RemoveField(
            model_name='employee',
            name='location',
        ),
        migrations.RemoveField(
            model_name='employee',
            name='supervisor',
        ),
        migrations.RemoveField(
            model_name='employee_skills',
            name='employee_id',
        ),
        migrations.RemoveField(
            model_name='employee_skills',
            name='skill_id',
        ),
        migrations.RemoveField(
            model_name='filled_task',
            name='employee_id',
        ),
        migrations.RemoveField(
            model_name='filled_task',
            name='task_id',
        ),
        migrations.RemoveField(
            model_name='picture',
            name='employee',
        ),
        migrations.RemoveField(
            model_name='posted_task',
            name='employee_id',
        ),
        migrations.RemoveField(
            model_name='posted_task',
            name='task_id',
        ),
        migrations.RemoveField(
            model_name='random_task',
            name='employee_id',
        ),
        migrations.RemoveField(
            model_name='random_task',
            name='task_id',
        ),
        migrations.RemoveField(
            model_name='task',
            name='department',
        ),
        migrations.RemoveField(
            model_name='task',
            name='location',
        ),
        migrations.RemoveField(
            model_name='task',
            name='status',
        ),
        migrations.RemoveField(
            model_name='task_skills',
            name='skill_id',
        ),
        migrations.RemoveField(
            model_name='task_skills',
            name='task_id',
        ),
        migrations.DeleteModel(
            name='Account',
        ),
        migrations.DeleteModel(
            name='Applied_Task',
        ),
        migrations.DeleteModel(
            name='Company',
        ),
        migrations.DeleteModel(
            name='CV',
        ),
        migrations.DeleteModel(
            name='Department',
        ),
        migrations.DeleteModel(
            name='Employee',
        ),
        migrations.DeleteModel(
            name='Employee_Skills',
        ),
        migrations.DeleteModel(
            name='Filled_Task',
        ),
        migrations.DeleteModel(
            name='Location',
        ),
        migrations.DeleteModel(
            name='Picture',
        ),
        migrations.DeleteModel(
            name='Posted_Task',
        ),
        migrations.DeleteModel(
            name='Random_Task',
        ),
        migrations.DeleteModel(
            name='Skill',
        ),
        migrations.DeleteModel(
            name='Status',
        ),
        migrations.DeleteModel(
            name='Task',
        ),
        migrations.DeleteModel(
            name='Task_Skills',
        ),
    ]
