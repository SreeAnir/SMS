
@extends('layouts.admin.app')
@section('title', 'Calendar')
@section('content')
<div id="calendar"> </div>
@php


$encodedEvents = json_encode($events);
@endphp
@endsection

@push('styles')
<style>
#calendar {
    /* max-width: 1100px; */
    margin: 0 auto;
  }
  a{
    color: rgb(19, 16, 16);
  }
</style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css" />
@endpush

@push('scripts')
 
<script>
// Get the current date
var today = new Date();

// Format the date as 'YYYY-MM-DD'
var formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + ('0' + today.getDate()).slice(-2);

    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
  
      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'multiMonthYear,dayGridMonth,timeGridWeek'
        },
        initialView: 'dayGridMonth',
        initialDate: formattedDate,
        editable: true,
        selectable: true,
        dayMaxEvents: true, // allow "more" link when too many events
        // multiMonthMaxColumns: 1, // guarantee single column
        // showNonCurrentDates: true,
        // fixedWeekCount: false,
        // businessHours: true,
        // weekends: false,
        events: <?php echo $encodedEvents; ?>
      });
  
      calendar.render();
    });
  
  </script>
@endpush
