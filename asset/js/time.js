function twoDigit(num) {
    let ret;
    if(num < 10)
        ret = "0"+ num; 
    else 
         ret = num; 
    return ret;
}

function Clock(){
    let nowtime = new Date();
    let days = ['日','月','火','水','木','金','土'];
    let nowYear = nowtime.getFullYear();
    let nowMonth = nowtime.getMonth()+1;
    let nowDate = nowtime.getDate();
    let nowDay = nowtime.getDay();
    let nowHour = twoDigit(nowtime.getHours());
    let nowMin = twoDigit(nowtime.getMinutes());
    let nowSec = twoDigit(nowtime.getSeconds());
    let times = nowYear +"年"+ nowMonth +"月"+ nowDate +"日　"+ days[nowDay] +"曜日　"+ nowHour +"時"+ nowMin + "分";
    document.getElementById("now").innerHTML = times;
}

function startClock() {
    Clock();
    setInterval(Clock, 1000);
}
