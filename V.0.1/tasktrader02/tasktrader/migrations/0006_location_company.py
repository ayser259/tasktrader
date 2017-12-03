# -*- coding: utf-8 -*-
# Generated by Django 1.11.7 on 2017-12-03 02:43
from __future__ import unicode_literals

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('tasktrader', '0005_remove_location_company'),
    ]

    operations = [
        migrations.AddField(
            model_name='location',
            name='company',
            field=models.ForeignKey(default=0, on_delete=django.db.models.deletion.CASCADE, to='tasktrader.Company'),
        ),
    ]