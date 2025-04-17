document.addEventListener('DOMContentLoaded', function () {
    const calendar = document.getElementById('calendar');
    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth();

    function generateCalendar(year, month) {
        const firstDay = new Date(year, month, 1);
        const startingDay = firstDay.getDay();
        const monthLength = new Date(year, month + 1, 0).getDate();
        const today = now.getDate();

        let calendarHTML = '<table class="w-full border-collapse">';
        calendarHTML += '<thead><tr>';
        calendarHTML += '<th class="border p-2">日</th>';
        calendarHTML += '<th class="border p-2">一</th>';
        calendarHTML += '<th class="border p-2">二</th>';
        calendarHTML += '<th class="border p-2">三</th>';
        calendarHTML += '<th class="border p-2">四</th>';
        calendarHTML += '<th class="border p-2">五</th>';
        calendarHTML += '<th class="border p-2">六</th>';
        calendarHTML += '</tr></thead>';
        calendarHTML += '<tbody><tr>';

        let day = 1;
        for (let i = 0; i < 7; i++) {
            if (i < startingDay) {
                calendarHTML += '<td class="border p-2"></td>';
            } else {
                const isToday = day === today;
                let cellClass = 'border p-2';
                if (isToday) {
                    cellClass += ' bg-blue-200';
                }
                calendarHTML += `<td class="${cellClass}" data-date="${year}-${month + 1}-${day}">${day}</td>`;
                day++;
            }
        }
        calendarHTML += '</tr>';

        while (day <= monthLength) {
            calendarHTML += '<tr>';
            for (let i = 0; i < 7; i++) {
                if (day <= monthLength) {
                    const isToday = day === today;
                    let cellClass = 'border p-2';
                    if (isToday) {
                        cellClass += ' bg-blue-200';
                    }
                    calendarHTML += `<td class="${cellClass}" data-date="${year}-${month + 1}-${day}">${day}</td>`;
                    day++;
                } else {
                    calendarHTML += '<td class="border p-2"></td>';
                }
            }
            calendarHTML += '</tr>';
        }

        calendarHTML += '</tbody></table>';
        calendar.innerHTML = calendarHTML;

        // 绑定签到事件
        const cells = calendar.querySelectorAll('td[data-date]');
        cells.forEach(cell => {
            cell.addEventListener('click', function () {
                const date = this.dataset.date;
                // 发送签到请求
                fetch('php/sign_in.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ date: date })
                })
              .then(response => response.json())
              .then(data => {
                    if (data.success) {
                        this.classList.add('bg-green-200');
                        alert('签到成功');
                    } else {
                        alert('签到失败: ' + data.message);
                    }
                })
              .catch(error => {
                    alert('签到失败: ' + error.message);
                });
            });
        });

        // 获取已签到日期
        fetch('php/get_signed_dates.php')
          .then(response => response.json())
          .then(data => {
                const signedDates = data.signed_dates;
                cells.forEach(cell => {
                    const date = cell.dataset.date;
                    if (signedDates.includes(date)) {
                        cell.classList.add('bg-green-200');
                    }
                });
            })
          .catch(error => {
                alert('获取签到信息失败: ' + error.message);
            });
    }

    generateCalendar(year, month);
});
    