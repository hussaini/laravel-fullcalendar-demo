import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import bootstrapPlugin from '@fullcalendar/bootstrap'
import 'bootstrap'
import 'gijgo'
import 'dayjs'
import Axios from 'axios'

import 'bootstrap/dist/css/bootstrap.css'
import '@fortawesome/fontawesome-free/css/all.css'
import 'gijgo/css/gijgo.min.css'
import dayjs from 'dayjs';

document.addEventListener('DOMContentLoaded', () => {
    const inputId = 'inputId'
    const inputTitle = 'inputTitle'
    const inputStartDate = 'inputStartDate'
    const inputEndDate = 'inputEndDate'
    const textareaDetails = 'textareaDetails'
    const btnSave = 'btnSave'
    const btnDel = 'btnDel'
    const modalCalendar = 'modalCalendar'
    const baseUri = '/api/events'

    const datePickerOptions = {
        uiLibrary: 'bootstrap4',
        format: 'dd-mmm-yyyy',
        weekStartDay: 1,
    }

    $(`#${inputStartDate}`).datepicker(datePickerOptions)
    $(`#${inputEndDate}`).datepicker(datePickerOptions)

    const calendarEl = document.getElementById('calendar')
    const calendar = new Calendar(calendarEl, {
        plugins: [ dayGridPlugin, interactionPlugin, bootstrapPlugin ],
        aspectRatio: 1.6,
        displayEventTime: false,
        weekNumberCalculation: 'ISO',
        themeSystem: 'bootstrap',
        events: (info, success, failure) => {
            console.log(info)
            Axios({
                method: 'get',
                url: baseUri,
                params: {
                    startAt: info.startStr,
                    endAt: info.endStr,
                }
            }).then((response) => {
                const events = response.data

                success(events.map((event) => {
                    return {
                        id: event.id,
                        title: event.title,
                        details: event.details,
                        start: event.startAt,
                        end: event.endAt,
                        allDay: event.allDay,
                    }
                }))
            }).catch((error) => {
                failure()
            })
        },
        eventClick: (info, jsEvent, view) => {
            $(`#${inputId}`).val(info.event.id)
            $(`#${inputTitle}`).val(info.event.title)
            $(`#${inputStartDate}`).val(dayjs(info.event.startStr).format('DD-MMM-YYYY'))

            if (info.event.endStr !== '') {
                $(`#${inputEndDate}`).val(dayjs(info.event.endStr).format('DD-MMM-YYYY'))
            } else {
                $(`#${inputEndDate}`).val(dayjs(info.event.startStr).format('DD-MMM-YYYY'))
            }

            if (info.event.extendedProps.details !== null) {
                $(`#${textareaDetails}`).html(info.event.extendedProps.details)
            }

            $(`#${modalCalendar}`).modal('show')
        },
        dateClick: (info) => {
            $(`#${inputId}`).val('')
            $(`#${inputTitle}`).val('')
            $(`#${inputStartDate}`).val(dayjs(info.dateStr).format('DD-MMM-YYYY'))
            $(`#${inputEndDate}`).val(dayjs(info.dateStr).format('DD-MMM-YYYY'))
            $(`#${textareaDetails}`).val('')
            $(`#${modalCalendar}`).modal('show')
        },
    })

    $(`#${btnSave}`).click((e) => {
        e.preventDefault()

        const data = {
            id: $(`#${inputId}`).val(),
            title: $(`#${inputTitle}`).val(),
            details: $(`#${textareaDetails}`).val(),
            startAt: $(`#${inputStartDate}`).val(),
            endAt: $(`#${inputEndDate}`).val(),
        }

        let method = 'post'
        let url = '/api/events'

        if (data.id) {
            method = 'patch'
            url = `${url}/${data.id}`
        }

        Axios({
            method,
            url,
            data
        }).then((response) => {
            const responseData = response.data

            if (method === 'post') {
                const inputEvent = Object.assign(responseData, {
                    start: responseData.startAt,
                    end: responseData.endAt,
                })
                calendar.addEvent(inputEvent)
            } else if (method === 'patch') {
                const event = calendar.getEventById(responseData.id)

                event.setDates(responseData.startAt, responseData.endAt === responseData.startAt ? null : responseData.endAt, {
                    allDay: responseData.allDay,
                })
                event.setProp('title', responseData.title)
                event.setExtendedProp('details', responseData.details)
            }

            $('#modalCalendar').modal('hide')
        }).catch((error) => {
            console.log(error)
        })
    })

    $(`#${btnDel}`).click((e) => {
        const id = $(`#${inputId}`).val()

        Axios({
            method: 'delete',
            url: `/api/events/${id}`,
        }).then(() => {
            const event = calendar.getEventById(id)
            if (event) {
                event.remove()
            }

            $(`#${modalCalendar}`).modal('hide')
        })
    })

    calendar.render()
})