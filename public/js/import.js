import * as XLSX from "./xlsx";
import * as path from "path";

function getDataFromExcel() {
    const XLSX = require('xlsx');
    const file = path.resolve('assets\\datas', 'wired_beauty_datas.xlsx');
    // recuperer fichier formulaire html
    // lire le fichier bineaire avec le fichier xlsx
    const workbook = XLSX.readFile(file, {type: 'string', codepage: 65001});
    const data = [];    let worksheet = workbook.SheetNames;
    for (let i = 0; i < worksheet.length; i++) {
        worksheet = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[i]]);
        worksheet.map((line) => {data.push(line);

        });
    }
    console.log(data, 'data shoulld print');
    return data;
}