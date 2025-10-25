document.addEventListener('DOMContentLoaded', function() {
    const datepickerInputs = document.querySelectorAll('.datepicker, .datepicker-filtro');
    
    datepickerInputs.forEach(input => {
        const wrapper = document.createElement('div');
        wrapper.className = 'datepicker-wrapper';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        
        const calendarIcon = document.createElement('span');
        calendarIcon.className = 'calendar-icon';
        calendarIcon.innerHTML = '📅';
        wrapper.appendChild(calendarIcon);
        
        const calendar = createCalendar(input);
        wrapper.appendChild(calendar);
        
        calendarIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            calendar.style.display = calendar.style.display === 'block' ? 'none' : 'block';
        });
        
        input.addEventListener('focus', function() {
            calendar.style.display = 'block';
        });
        
        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) {
                calendar.style.display = 'none';
            }
        });
        
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' || e.key === 'Delete' || e.key === 'Tab') {
                return;
            }
            
            const value = e.target.value.replace(/\D/g, '');
            
            if (value.length >= 8 && e.key >= '0' && e.key <= '9') {
                e.preventDefault();
            }
        });
        
        input.addEventListener('input', function(e) {
            const cursorPos = e.target.selectionStart;
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            
            if (value.length > 0) {
                formattedValue = value.substring(0, 2);
            }
            if (value.length >= 3) {
                formattedValue += '/' + value.substring(2, 4);
            }
            if (value.length >= 5) {
                formattedValue += '/' + value.substring(4, 8);
            }
            
            e.target.value = formattedValue;
            
            let newCursorPos = cursorPos;
            if (cursorPos === 3 || cursorPos === 6) {
                newCursorPos = cursorPos + 1;
            }
            e.target.setSelectionRange(newCursorPos, newCursorPos);
        });
        
        input.addEventListener('blur', function(e) {
            const value = e.target.value;
            const parts = value.split('/');
            
            if (value && parts.length === 3) {
                const day = parseInt(parts[0]);
                const month = parseInt(parts[1]);
                const year = parseInt(parts[2]);
                
                if (day < 1 || day > 31 || month < 1 || month > 12 || year < 1900) {
                    alert('Fecha inválida. Use formato dd/mm/aaaa');
                    e.target.value = '';
                }
            }
        });
    });
});

function createCalendar(input) {
    const calendar = document.createElement('div');
    calendar.className = 'calendar-popup';
    calendar.style.display = 'none';
    
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    
    function renderCalendar() {
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay();
        
        let html = `
            <div class="calendar-header">
                <button type="button" class="cal-prev">◀</button>
                <span class="cal-month-year">${getMonthName(currentMonth)} ${currentYear}</span>
                <button type="button" class="cal-next">▶</button>
            </div>
            <div class="calendar-grid">
                <div class="cal-day-name">D</div>
                <div class="cal-day-name">L</div>
                <div class="cal-day-name">M</div>
                <div class="cal-day-name">M</div>
                <div class="cal-day-name">J</div>
                <div class="cal-day-name">V</div>
                <div class="cal-day-name">S</div>
        `;
        
        for (let i = 0; i < startingDayOfWeek; i++) {
            html += '<div class="cal-day empty"></div>';
        }
        
        for (let day = 1; day <= daysInMonth; day++) {
            const isToday = day === today.getDate() && 
                          currentMonth === today.getMonth() && 
                          currentYear === today.getFullYear();
            const className = isToday ? 'cal-day today' : 'cal-day';
            html += `<div class="${className}" data-day="${day}">${day}</div>`;
        }
        
        html += '</div>';
        calendar.innerHTML = html;
        
        calendar.querySelector('.cal-prev').addEventListener('click', function(e) {
            e.stopPropagation();
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        });
        
        calendar.querySelector('.cal-next').addEventListener('click', function(e) {
            e.stopPropagation();
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        });
        
        calendar.querySelectorAll('.cal-day:not(.empty)').forEach(dayEl => {
            dayEl.addEventListener('click', function(e) {
                e.stopPropagation();
                const day = this.dataset.day.padStart(2, '0');
                const month = (currentMonth + 1).toString().padStart(2, '0');
                const year = currentYear;
                input.value = `${day}/${month}/${year}`;
                calendar.style.display = 'none';
            });
        });
    }
    
    renderCalendar();
    return calendar;
}

function getMonthName(month) {
    const months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                   'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    return months[month];
}