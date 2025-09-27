/**
 * @type {HTMLInputElement}
 */
const table = document.getElementById("searchtable");
/**
 * @type {HTMLInputElement}
 */
const input = document.getElementById("searchbar");
/**
 * @type {HTMLInputElement}
 */
const dateinput = document.getElementById("datebar");


input.addEventListener('keyup', () => {
    searchTable();
})


dateinput.addEventListener('input', () => {
    searchTable();
})


function searchTable() {
    const filter = input.value.trim().toUpperCase();
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    const notfound = document.getElementById("notfoundtext");
    var hasResult = false;
    let dateFilter = "";
    if (dateinput.value) {
        const [year, month, day] = dateinput.value.split("-");
        dateFilter = `${day}/${month}/${year}`;
    }
    if (!filter && !dateFilter) {
        for (let row of rows) {
            row.style.display = '';
        }
        notfound.style.display = 'none';
        return;
    }

    for (let index = 0; index < rows.length; index++) {
        const cells = rows[index].getElementsByTagName('td')
        let found = false

        for (let i = 0; i < cells.length; i++) {
            const cell = cells[i].textContent || cells[i].innerText;

            // กรณีมีทั้ง search text และ date
            if (filter && dateFilter) {
                if (cell.toUpperCase().indexOf(filter) > -1 && cell.indexOf(dateFilter) > -1) {
                    found = true;
                    hasResult = true;
                    break;
                }
            }
            // กรณีกรอกเฉพาะ search text
            else if (filter) {
                if (cell.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    hasResult = true;
                    break;
                }
            }
            // กรณีเลือกเฉพาะ date
            else if (dateFilter) {
                if (cell.indexOf(dateFilter) > -1) {
                    found = true;
                    hasResult = true;
                    break;
                }
            }

        }
        rows[index].style.display = found ? '' : 'none';
    }

    //display Error
    if (!hasResult) {
        notfound.style.display = 'block';
    } else {
        notfound.style.display = 'none';
    }
}