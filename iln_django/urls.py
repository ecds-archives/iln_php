from django.conf.urls.defaults import *
from django.conf import settings
from django.conf.urls.static import static
from django.contrib.staticfiles.urls import staticfiles_urlpatterns

from django.contrib import admin
admin.autodiscover()

from iln_django.views import index, introduction, bibliography, about, links, searchform, article_display, volumes, volume_display, illustrations

urlpatterns = patterns('iln_django.views',
    url(r'^$', 'index', name='index'),
    url(r'^introduction$', 'introduction', name='introduction'),
    url(r'^bibliography$', 'bibliography', name='bibliography'),
    url(r'^about$', 'about', name='about'),
    url(r'^links$', 'links', name='links'),
    url(r'^search$', 'searchform', name='searchform'),
    url(r'^browse/(?P<div_id>[^/]+)/$', 'article_display', name='article_display'),
    url(r'^volume/(?P<vol_id>[^/]+)/$', 'volume_display', name='volume_display'),
    url(r'^volumes$', 'volumes', name='volumes'),
    url(r'^illustrations$', 'illustrations', name='illustrations'),
    )
   


#if settings.DEBUG:
  #urlpatterns += staticfiles_urlpatterns(
       #url(r'^static/(?P<path>.*)$', 'django.views.static.serve', {'document_root': settings.STATIC_ROOT } ),
    #)
