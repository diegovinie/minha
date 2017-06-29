function showUl(json){
    if(json.length <= 2){
        return '<span>No hay usuarios registrados</span>'
    }
    console.log(json);
    var data = JSON.parse(json)
    var table = document.createElement('table')
    list = "";
    for(var i = 0; i < data.length; i++){
        var j = "";
        for (var col in data[i]) {
            if (data[i].hasOwnProperty(col)) {
                j += '<li class="list-group-item" id=' + escape(col) +' value=' + data[i][col] + '>' + col + ": " + data[i][col] + " </li>\n";
            }
            var user = "<ul 'class=list-group'>" + j + "</ul>"
        }
        list += user;
    }
    return list
}

function showSelect(json){
	if(json.length <= 2){
		return '<span>Error</span>'
	}
	data = JSON.parse(json)
	var j = "";
	for(var i = 0; i < data.length; i++){
		j += "<option value="+data[i].lap_id+">"+data[i].lap_name+"</option>\n"
	}
	var jj = "<select>"+j+"</select>"
	return j
}

function unwrap(json){
    if(json.length <= 2){
        return '<span>Error</span>'
    }
    data = JSON.parse(json)
    var table = document.createElement('table');
    for(i in data){
        var tr = document.createElement('tr');
        for(j in data[i]){
            var td = document.createElement('td');
            td.innerHTML = data[i][j];
            tr.appendChild(td);
        }
        table.appendChild(tr);
    }
    table = "<table>" + table.innerHTML + "</table>";
    return table;
}
