
function getDataFromExcel() {

    const file = path.resolve('assets\\datas', 'wired_beauty_datas.xlsx');
    const workbook = XLSX.readFile(file, {type: 'string', codepage: 65001});
    const data = [];    let worksheet = workbook.SheetNames;
    for (let i = 0; i < worksheet.length; i++) {
        worksheet = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[i]]);
        worksheet.map((line) => {data.push(line);
        });
    }
    return data;
}