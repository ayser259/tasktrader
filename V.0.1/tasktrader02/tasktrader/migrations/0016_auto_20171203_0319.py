# -*- coding: utf-8 -*-
# Generated by Django 1.11.7 on 2017-12-03 03:19
from __future__ import unicode_literals

import datetime
from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    initial = True

    dependencies = [
        ('tasktrader', '0015_auto_20171203_0319'),
    ]

    operations = [
        migrations.CreateModel(
            name='Account',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('username', models.CharField(max_length=20)),
                ('password', models.CharField(max_length=20)),
            ],
        ),
        migrations.CreateModel(
            name='Applied_Task',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
            ],
        ),
        migrations.CreateModel(
            name='Company',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('company_name', models.CharField(max_length=30)),
            ],
        ),
        migrations.CreateModel(
            name='CV',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('cv', models.FileField(upload_to='resumés')),
            ],
        ),
        migrations.CreateModel(
            name='Department',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('department_name', models.CharField(max_length=30)),
                ('company_id', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Company')),
            ],
        ),
        migrations.CreateModel(
            name='Employee',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('job_title', models.CharField(max_length=20)),
                ('first_name', models.CharField(max_length=20)),
                ('last_name', models.CharField(max_length=20)),
                ('department', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Department')),
            ],
        ),
        migrations.CreateModel(
            name='Employee_Skills',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('employee_id', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Employee')),
            ],
        ),
        migrations.CreateModel(
            name='Filled_Task',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('employee_id', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Employee')),
            ],
        ),
        migrations.CreateModel(
            name='Location',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('campus_name', models.CharField(max_length=30)),
                ('city', models.CharField(max_length=30)),
                ('country', models.CharField(max_length=30)),
                ('street_address', models.CharField(max_length=30)),
                ('postal_code', models.CharField(max_length=30)),
                ('company_id', models.ForeignKey(default=-1, on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Company')),
            ],
        ),
        migrations.CreateModel(
            name='Picture',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('picture', models.ImageField(upload_to='Profile_Pictures')),
                ('employee', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Employee')),
            ],
        ),
        migrations.CreateModel(
            name='Posted_Task',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('employee_id', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Employee')),
            ],
        ),
        migrations.CreateModel(
            name='Random_Task',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('employee_id', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Employee')),
            ],
        ),
        migrations.CreateModel(
            name='Skill',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('skill_name', models.CharField(max_length=20)),
            ],
        ),
        migrations.CreateModel(
            name='Status',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('status_type', models.CharField(max_length=20)),
            ],
        ),
        migrations.CreateModel(
            name='Task',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('task_title', models.CharField(max_length=30)),
                ('task_description', models.CharField(max_length=50)),
                ('end_date', models.DateField(null=True)),
                ('start_date', models.DateField(null=True)),
                ('time_commitment', models.DateTimeField(blank=True, default=datetime.datetime.now)),
                ('department', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Department')),
                ('location', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Location')),
                ('status', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Status')),
            ],
        ),
        migrations.CreateModel(
            name='Task_Skills',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('skill_id', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Skill')),
                ('task_id', models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Task')),
            ],
        ),
        migrations.AddField(
            model_name='random_task',
            name='task_id',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Task'),
        ),
        migrations.AddField(
            model_name='posted_task',
            name='task_id',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Task'),
        ),
        migrations.AddField(
            model_name='filled_task',
            name='task_id',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Task'),
        ),
        migrations.AddField(
            model_name='employee_skills',
            name='skill_id',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Skill'),
        ),
        migrations.AddField(
            model_name='employee',
            name='location',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Location'),
        ),
        migrations.AddField(
            model_name='employee',
            name='supervisor',
            field=models.ForeignKey(blank=True, null=True, on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Employee'),
        ),
        migrations.AddField(
            model_name='cv',
            name='employee',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Employee'),
        ),
        migrations.AddField(
            model_name='applied_task',
            name='employee_id',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Employee'),
        ),
        migrations.AddField(
            model_name='applied_task',
            name='task_id',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Task'),
        ),
        migrations.AddField(
            model_name='account',
            name='owner',
            field=models.ForeignKey(on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Employee'),
        ),
    ]