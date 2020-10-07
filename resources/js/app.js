import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import bootstrapPlugin from '@fullcalendar/bootstrap'
import 'bootstrap'

import 'bootstrap/dist/css/bootstrap.css'
import '@fortawesome/fontawesome-free/css/all.css'

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar')

    const calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, interactionPlugin, bootstrapPlugin ],
        aspectRatio: 1.6,
        themeSystem: 'bootstrap',
        events: '/api/events',
        eventClick: (info, jsEvent, view) => {
            $('#modalTitle').text(info.event.title)
            if(info.event.extendedProps.details != null) {
                $('#modalBody').html(info.event.extendedProps.details)
            }

            $('#modalCalendar').modal('show');
        },
    })

    calendar.render()
})