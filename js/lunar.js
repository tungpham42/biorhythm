/*
 * Copyright (c) 2006 Ho Ngoc Duc. All Rights Reserved.
 * Astronomical algorithms from the book "Astronomical Algorithms" by Jean Meeus, 1998
 *
 * Permission to use, copy, modify, and redistribute this software and its
 * documentation for personal, non-commercial use is hereby granted provided that
 * this copyright notice and appropriate documentation appears in all copies.
 */
var PI = Math.PI;

/* Discard the fractional part of a number, e.g., INT(3.2) = 3 */
function INT(d) {
	return Math.floor(d);
}

/* Compute the (integral) Julian day number of day dd/mm/yyyy, i.e., the number 
 * of days between 1/1/4713 BC (Julian calendar) and dd/mm/yyyy. 
 * Formula from http://www.tondering.dk/claus/calendar.html
 */
function jdFromDate(dd, mm, yy) {
	var a, y, m, jd;
	a = INT((14 - mm) / 12);
	y = yy+4800-a;
	m = mm+12*a-3;
	jd = dd + INT((153*m+2)/5) + 365*y + INT(y/4) - INT(y/100) + INT(y/400) - 32045;
	if (jd < 2299161) {
		jd = dd + INT((153*m+2)/5) + 365*y + INT(y/4) - 32083;
	}
	return jd;
}

/* Convert a Julian day number to day/month/year. Parameter jd is an integer */
function jdToDate(jd) {
	var a, b, c, d, e, m, day, month, year;
	if (jd > 2299160) { // After 5/10/1582, Gregorian calendar
		a = jd + 32044;
		b = INT((4*a+3)/146097);
		c = a - INT((b*146097)/4);
	} else {
		b = 0;
		c = jd + 32082;
	}
	d = INT((4*c+3)/1461);
	e = c - INT((1461*d)/4);
	m = INT((5*e+2)/153);
	day = e - INT((153*m+2)/5) + 1;
	month = m + 3 - 12*INT(m/10);
	year = b*100 + d - 4800 + INT(m/10);
	return new Array(day, month, year);
}

/* Compute the time of the k-th new moon after the new moon of 1/1/1900 13:52 UCT 
 * (measured as the number of days since 1/1/4713 BC noon UCT, e.g., 2451545.125 is 1/1/2000 15:00 UTC).
 * Returns a floating number, e.g., 2415079.9758617813 for k=2 or 2414961.935157746 for k=-2
 * Algorithm from: "Astronomical Algorithms" by Jean Meeus, 1998
 */
function NewMoon(k) {
	var T, T2, T3, dr, Jd1, M, Mpr, F, C1, deltat, JdNew;
	T = k/1236.85; // Time in Julian centuries from 1900 January 0.5
	T2 = T * T;
	T3 = T2 * T;
	dr = PI/180;
	Jd1 = 2415020.75933 + 29.53058868*k + 0.0001178*T2 - 0.000000155*T3;
	Jd1 = Jd1 + 0.00033*Math.sin((166.56 + 132.87*T - 0.009173*T2)*dr); // Mean new moon
	M = 359.2242 + 29.10535608*k - 0.0000333*T2 - 0.00000347*T3; // Sun's mean anomaly
	Mpr = 306.0253 + 385.81691806*k + 0.0107306*T2 + 0.00001236*T3; // Moon's mean anomaly
	F = 21.2964 + 390.67050646*k - 0.0016528*T2 - 0.00000239*T3; // Moon's argument of latitude
	C1=(0.1734 - 0.000393*T)*Math.sin(M*dr) + 0.0021*Math.sin(2*dr*M);
	C1 = C1 - 0.4068*Math.sin(Mpr*dr) + 0.0161*Math.sin(dr*2*Mpr);
	C1 = C1 - 0.0004*Math.sin(dr*3*Mpr);
	C1 = C1 + 0.0104*Math.sin(dr*2*F) - 0.0051*Math.sin(dr*(M+Mpr));
	C1 = C1 - 0.0074*Math.sin(dr*(M-Mpr)) + 0.0004*Math.sin(dr*(2*F+M));
	C1 = C1 - 0.0004*Math.sin(dr*(2*F-M)) - 0.0006*Math.sin(dr*(2*F+Mpr));
	C1 = C1 + 0.0010*Math.sin(dr*(2*F-Mpr)) + 0.0005*Math.sin(dr*(2*Mpr+M));
	if (T < -11) {
		deltat= 0.001 + 0.000839*T + 0.0002261*T2 - 0.00000845*T3 - 0.000000081*T*T3;
	} else {
		deltat= -0.000278 + 0.000265*T + 0.000262*T2;
	};
	JdNew = Jd1 + C1 - deltat;
	return JdNew;
}

/* Compute the longitude of the sun at any time. 
 * Parameter: floating number jdn, the number of days since 1/1/4713 BC noon
 * Algorithm from: "Astronomical Algorithms" by Jean Meeus, 1998
 */
function SunLongitude(jdn) {
	var T, T2, dr, M, L0, DL, L;
	T = (jdn - 2451545.0 ) / 36525; // Time in Julian centuries from 2000-01-01 12:00:00 GMT
	T2 = T*T;
	dr = PI/180; // degree to radian
	M = 357.52910 + 35999.05030*T - 0.0001559*T2 - 0.00000048*T*T2; // mean anomaly, degree
	L0 = 280.46645 + 36000.76983*T + 0.0003032*T2; // mean longitude, degree
	DL = (1.914600 - 0.004817*T - 0.000014*T2)*Math.sin(dr*M);
	DL = DL + (0.019993 - 0.000101*T)*Math.sin(dr*2*M) + 0.000290*Math.sin(dr*3*M);
	L = L0 + DL; // true longitude, degree
	L = L*dr;
	L = L - PI*2*(INT(L/(PI*2))); // Normalize to (0, 2*PI)
	return L;
}

/* Compute sun position at midnight of the day with the given Julian day number. 
 * The time zone if the time difference between local time and UTC: 7.0 for UTC+7:00.
 * The function returns a number between 0 and 11. 
 * From the day after March equinox and the 1st major term after March equinox, 0 is returned. 
 * After that, return 1, 2, 3 ... 
 */
function getSunLongitude(dayNumber, timeZone) {
	return INT(SunLongitude(dayNumber - 0.5 - timeZone/24)/PI*6);
}

/* Compute the day of the k-th new moon in the given time zone.
 * The time zone if the time difference between local time and UTC: 7.0 for UTC+7:00
 */
function getNewMoonDay(k, timeZone) {
	return INT(NewMoon(k) + 0.5 + timeZone/24);
}

/* Find the day that starts the luner month 11 of the given year for the given time zone */
function getLunarMonth11(yy, timeZone) {
	var k, off, nm, sunLong;
	//off = jdFromDate(31, 12, yy) - 2415021.076998695;
	off = jdFromDate(31, 12, yy) - 2415021;
	k = INT(off / 29.530588853);
	nm = getNewMoonDay(k, timeZone);
	sunLong = getSunLongitude(nm, timeZone); // sun longitude at local midnight
	if (sunLong >= 9) {
		nm = getNewMoonDay(k-1, timeZone);
	}
	return nm;
}

/* Find the index of the leap month after the month starting on the day a11. */
function getLeapMonthOffset(a11, timeZone) {
	var k, last, arc, i;
	k = INT((a11 - 2415021.076998695) / 29.530588853 + 0.5);
	last = 0;
	i = 1; // We start with the month following lunar month 11
	arc = getSunLongitude(getNewMoonDay(k+i, timeZone), timeZone);
	do {
		last = arc;
		i++;
		arc = getSunLongitude(getNewMoonDay(k+i, timeZone), timeZone);
	} while (arc != last && i < 14);
	return i-1;
}

/* Comvert solar date dd/mm/yyyy to the corresponding lunar date */
function convertSolarToLunar(dd, mm, yy, timeZone) {
	var k, dayNumber, monthStart, a11, b11, lunarDay, lunarMonth, lunarYear, lunarLeap;
	dayNumber = jdFromDate(dd, mm, yy);
	k = INT((dayNumber - 2415021.076998695) / 29.530588853);
	monthStart = getNewMoonDay(k+1, timeZone);
	if (monthStart > dayNumber) {
		monthStart = getNewMoonDay(k, timeZone);
	}
	//alert(dayNumber+" -> "+monthStart);
	a11 = getLunarMonth11(yy, timeZone);
	b11 = a11;
	if (a11 >= monthStart) {
		lunarYear = yy;
		a11 = getLunarMonth11(yy-1, timeZone);
	} else {
		lunarYear = yy+1;
		b11 = getLunarMonth11(yy+1, timeZone);
	}
	lunarDay = dayNumber-monthStart+1;
	diff = INT((monthStart - a11)/29);
	lunarLeap = 0;
	lunarMonth = diff+11;
	if (b11 - a11 > 365) {
		leapMonthDiff = getLeapMonthOffset(a11, timeZone);
		if (diff >= leapMonthDiff) {
			lunarMonth = diff + 10;
			if (diff == leapMonthDiff) {
				lunarLeap = 1;
			}
		}
	}
	if (lunarMonth > 12) {
		lunarMonth = lunarMonth - 12;
	}
	if (lunarMonth >= 11 && diff < 4) {
		lunarYear -= 1;
	}
	return new Array(lunarDay, lunarMonth, lunarYear, lunarLeap);
}

/* Convert a lunar date to the corresponding solar date */
function convertLunarToSolar(lunarDay, lunarMonth, lunarYear, lunarLeap, timeZone) {
	var k, a11, b11, off, leapOff, leapMonth, monthStart;
	if (lunarMonth < 11) {
		a11 = getLunarMonth11(lunarYear-1, timeZone);
		b11 = getLunarMonth11(lunarYear, timeZone);
	} else {
		a11 = getLunarMonth11(lunarYear, timeZone);
		b11 = getLunarMonth11(lunarYear+1, timeZone);
	}
	k = INT(0.5 + (a11 - 2415021.076998695) / 29.530588853);
	off = lunarMonth - 11;
	if (off < 0) {
		off += 12;
	}
	if (b11 - a11 > 365) {
		leapOff = getLeapMonthOffset(a11, timeZone);
		leapMonth = leapOff - 2;
		if (leapMonth < 0) {
			leapMonth += 12;
		}
		if (lunarLeap != 0 && lunarMonth != leapMonth) {
			return new Array(0, 0, 0);
		} else if (lunarLeap != 0 || off >= leapOff) {
			off += 1;
		}
	}
	monthStart = getNewMoonDay(k+off, timeZone);
	return jdToDate(monthStart+lunarDay-1);
}
function getLunarDate(date) {
	var date = new Date(date);
	var solarYear = date.getFullYear();
	var solarMonth = date.getMonth()+1;
	var solarDay = date.getDate();
	var lunarDate = convertSolarToLunar(solarDay,solarMonth,solarYear,7);
	return lunarDate;
}
function getLunarValues(lunarIndex) {
	var stemIndex = lunarIndex[0];
	var branchIndex = lunarIndex[1];
	var stem = '';
	var branch = '';
	switch(stemIndex) {
		case 0:	stem = 'Giáp'; break;
		case 1:	stem = 'Ất'; break;
		case 2:	stem = 'Bính'; break;
		case 3:	stem = 'Đinh'; break;
		case 4:	stem = 'Mậu'; break;
		case 5:	stem = 'Kỷ'; break;
		case 6:	stem = 'Canh'; break;
		case 7:	stem = 'Tân'; break;
		case 8:	stem = 'Nhâm'; break;
		case 9:	stem = 'Quý'; break;
	}
	switch(branchIndex) {
		case 0:	branch = 'Tý';	break;
		case 1:	branch = 'Sửu'; break;
		case 2:	branch = 'Dần'; break;
		case 3:	branch = 'Mẹo'; break;
		case 4:	branch = 'Thìn'; break;
		case 5:	branch = 'Tỵ';	break;
		case 6:	branch = 'Ngọ'; break;
		case 7:	branch = 'Mùi'; break;
		case 8:	branch = 'Thân'; break;
		case 9:	branch = 'Dậu'; break;
		case 10: branch = 'Tuất'; break;
		case 11: branch = 'Hợi'; break;
	}
	return new Array(stem,branch);
}
function getLunarYear(date) {
	var lunarDate = getLunarDate(date);
	var lunarYear = lunarDate[2];
	var stemIndex = (lunarYear+6)%10;
	var branchIndex = (lunarYear+8)%12;
	var lunarValues = getLunarValues(new Array(stemIndex,branchIndex));
	var stem = lunarValues[0];
	var branch = lunarValues[1];
	return lunarYear+' - '+stem+' '+branch;
}
function getLunarMonth(date) {
	var lunarDate = getLunarDate(date);
	var lunarYear = lunarDate[2];
	var lunarMonth = lunarDate[1];
	var lunarLeap = lunarDate[3];
	var stemIndex = (lunarYear*12+lunarMonth+3)%10;
	var branchIndex = (lunarMonth+1)%12;
	var lunarValues = getLunarValues(new Array(stemIndex,branchIndex));
	var stem = lunarValues[0];
	var branch = lunarValues[1];
	return lunarMonth+((lunarLeap == 1) ? ' nhuận': '')+' - '+stem+' '+branch;
}
function getLunarDay(date) {
	var lunarDate = getLunarDate(date);
	var lunarDay = lunarDate[0];
	var date = new Date(date);
	var solarYear = date.getFullYear();
	var solarMonth = date.getMonth()+1;
	var solarDay = date.getDate();
	var jd = jdFromDate(solarDay,solarMonth,solarYear);
	var stemIndex = (jd+9)%10;
	var branchIndex = (jd+1)%12;
	var lunarValues = getLunarValues(new Array(stemIndex,branchIndex));
	var stem = lunarValues[0];
	var branch = lunarValues[1];
	return lunarDay+' - '+stem+' '+branch;
}
function isLeapYear(year) {
  return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
}
function calculateLunarPeriodDate(date) { //http://www.informatik.uni-leipzig.de/~duc/sach/phongtuc/cau_109.html
	var date = new Date(date);
	var year = date.getFullYear();
	var month = date.getMonth()+1;
	var day = date.getDate();
	var periodDate = '';
	var leapDiff = isLeapYear(year) ? 1: 0;
	if (month == 2 && day == (4+leapDiff)) {
		periodDate = 'Lập xuân';
	} else if (month == 2 && day == (19+leapDiff)) {
		periodDate = 'Vũ thủy';
	} else if (month == 3 && day == (6+leapDiff)) {
		periodDate = 'Kinh trập';
	} else if (month == 3 && day == (21+leapDiff)) {
		periodDate = 'Xuân phân';
	} else if (month == 4 && day == (5+leapDiff)) {
		periodDate = 'Thanh minh';
	} else if (month == 4 && day == (20+leapDiff)) {
		periodDate = 'Cốc vũ';
	} else if (month == 5 && day == (6+leapDiff)) {
		periodDate = 'Lập hạ';
	} else if (month == 5 && day == (21+leapDiff)) {
		periodDate = 'Tiểu mãn';
	} else if (month == 6 && day == (6+leapDiff)) {
		periodDate = 'Mang chủng';
	} else if (month == 6 && day == (21+leapDiff)) {
		periodDate = 'Hạ chí';
	} else if (month == 7 && day == (7+leapDiff)) {
		periodDate = 'Tiểu thử';
	} else if (month == 7 && day == (23+leapDiff)) {
		periodDate = 'Đại thử';
	} else if (month == 8 && day == (8+leapDiff)) {
		periodDate = 'Lập thu';
	} else if (month == 8 && day == (23+leapDiff)) {
		periodDate = 'Xử thử';
	} else if (month == 9 && day == (8+leapDiff)) {
		periodDate = 'Bạch lộ';
	} else if (month == 9 && day == (23+leapDiff)) {
		periodDate = 'Thu phân';
	} else if (month == 10 && day == (8+leapDiff)) {
		periodDate = 'Hàn lộ';
	} else if (month == 10 && day == (23+leapDiff)) {
		periodDate = 'Sương giáng';
	} else if (month == 11 && day == (8+leapDiff)) {
		periodDate = 'Lập đông';
	} else if (month == 11 && day == (22+leapDiff)) {
		periodDate = 'Tiểu tuyết';
	} else if (month == 12 && day == (7+leapDiff)) {
		periodDate = 'Đại tuyết';
	} else if (month == 12 && day == (22+leapDiff)) {
		periodDate = 'Đông chí';
	} else if (month == 1 && day == (6+leapDiff)) {
		periodDate = 'Tiểu hàn';
	} else if (month == 1 && day == (20+leapDiff)) {
		periodDate = 'Đại hàn';
	} else if (month == 2 && (day > (4+leapDiff) && day < (19+leapDiff))) {
		periodDate = 'Lập xuân - Vũ thủy';
	} else if ((month == 2 && (day > (19+leapDiff) && day <= (28+leapDiff))) || (month == 3 && (day >= 1 && day < (6+leapDiff)))) {
		periodDate = 'Vũ thủy - Kinh trập';
	} else if (month == 3 && (day > (6+leapDiff) && day < (21+leapDiff))) {
		periodDate = 'Kinh trập - Xuân phân';
	} else if ((month == 3 && (day > (21+leapDiff) && day <= 31)) || (month == 4 && (day >= 1 && day < (5+leapDiff)))) {
		periodDate = 'Xuân phân - Thanh minh';
	} else if (month == 4 && (day > (5+leapDiff) && day < (20+leapDiff))) {
		periodDate = 'Thanh minh - Cốc vũ';
	} else if ((month == 4 && (day > (20+leapDiff) && day <= 30)) || (month == 5 && (day >= 1 && day < (6+leapDiff)))) {
		periodDate = 'Cốc vũ - Lập hạ';
	} else if (month == 5 && (day > (6+leapDiff) && day < (21+leapDiff))) {
		periodDate = 'Lập hạ - Tiểu mãn';
	} else if ((month == 5 && (day > (21+leapDiff) && day <= 31)) || (month == 6 && (day >= 1 && day < (6+leapDiff)))) {
		periodDate = 'Tiểu mãn - Mang chủng';
	} else if (month == 6 && (day > (6+leapDiff) && day < (21+leapDiff))) {
		periodDate = 'Mang chủng - Hạ chí';
	} else if ((month == 6 && (day > (21+leapDiff) && day <= 30)) || (month == 7 && (day >= 1 && day < (7+leapDiff)))) {
		periodDate = 'Hạ chí - Tiểu thử';
	} else if (month == 7 && (day > (7+leapDiff) && day < (23+leapDiff))) {
		periodDate = 'Tiểu thử - Đại thử';
	} else if ((month == 7 && (day > (23+leapDiff) && day <= 31)) || (month == 8 && (day >= 1 && day < (8+leapDiff)))) {
		periodDate = 'Đại thử - Lập thu';
	} else if (month == 8 && (day > (8+leapDiff) && day < (23+leapDiff))) {
		periodDate = 'Lập thu - Xử thử';
	} else if ((month == 8 && (day > (23+leapDiff) && day <= 31)) || (month == 9 && (day >= 1 && day < (8+leapDiff)))) {
		periodDate = 'Xử thử - Bạch lộ';
	} else if (month == 9 && (day > (8+leapDiff) && day < (23+leapDiff))) {
		periodDate = 'Bạch lộ - Thu phân';
	} else if ((month == 9 && (day > (23+leapDiff) && day <= 30)) || (month == 10 && (day >= 1 && day < (8+leapDiff)))) {
		periodDate = 'Thu phân - Hàn lộ';
	} else if (month == 10 && (day > (8+leapDiff) && day < (23+leapDiff))) {
		periodDate = 'Hàn lộ - Sương giáng';
	} else if ((month == 10 && (day > (23+leapDiff) && day <= 31)) || (month == 11 && (day >= 1 && day < (8+leapDiff)))) {
		periodDate = 'Sương giáng - Lập đông';
	} else if (month == 11 && (day > (8+leapDiff) && day < (22+leapDiff))) {
		periodDate = 'Lập đông - Tiểu tuyết';
	} else if ((month == 11 && (day > (22+leapDiff) && day <= 30)) || (month == 12 && (day >= 1 && day < (7+leapDiff)))) {
		periodDate = 'Tiểu tuyết - Đại tuyết';
	} else if (month == 12 && (day > (7+leapDiff) && day < (22+leapDiff))) {
		periodDate = 'Đại tuyết - Đông chí';
	} else if ((month == 12 && (day > (22+leapDiff) && day <= 31)) || (month == 1 && (day >= 1 && day < (6+leapDiff)))) {
		periodDate = 'Đông chí - Tiểu hàn';
	} else if (month == 1 && (day > (6+leapDiff) && day < (20+leapDiff))) {
		periodDate = 'Tiểu hàn - Đại hàn';
	} else if ((month == 1 && (day > (20+leapDiff) && day <= 31)) || (month == 2 && (day >= 1 && day < (4+leapDiff)))) {
		periodDate = 'Đại hàn - Lập xuân';
	}
	return periodDate;
}
function calculateLunarPeriod(date) { //http://www.informatik.uni-leipzig.de/~duc/sach/phongtuc/cau_109.html
	var periods = ['Kiến (tốt)','Trừ (thường)','Mãn (tốt)','Bình (tốt)','Định (tốt)','Chấp (thường)','Phá (xấu)','Nguy (xấu)','Thành (tốt)','Thu (thường)','Khai (tốt)','Bế (xấu)']
	var date = new Date(date);
	var year = date.getFullYear();
	var month = date.getMonth()+1;
	var day = date.getDate();
	var period = '';
	var jd = jdFromDate(day,month,year);
	var branchIndex = (jd+1)%12;
	var leapDiff = isLeapYear(year) ? 1: 0;
	if ((month == 2 && (day >= (4+leapDiff) && day <= (28+leapDiff))) || (month == 3 && (day >= 1 && day < (6+leapDiff)))) { // Sau lập xuân
		switch(branchIndex) {
			case 0:	period = periods[10]; break; // Tý
			case 1:	period = periods[11]; break; // Sửu
			case 2:	period = periods[0]; break; // Dần
			case 3:	period = periods[1]; break; // Mẹo
			case 4:	period = periods[2]; break; // Thìn
			case 5:	period = periods[3]; break; // Tỵ
			case 6:	period = periods[4]; break; // Ngọ
			case 7:	period = periods[5]; break; // Mùi
			case 8:	period = periods[6]; break; // Thân
			case 9:	period = periods[7]; break; // Dậu
			case 10: period = periods[8]; break; // Tuất
			case 11: period = periods[9]; break; // Hợi
		}
	} else if ((month == 3 && (day >= (6+leapDiff) && day <= 31)) || (month == 4 && (day >= 1 && day < (5+leapDiff)))) { // Sau kinh trập
		switch(branchIndex) {
			case 0:	period = periods[9]; break; // Tý
			case 1:	period = periods[10]; break; // Sửu
			case 2:	period = periods[11]; break; // Dần
			case 3:	period = periods[0]; break; // Mẹo
			case 4:	period = periods[1]; break; // Thìn
			case 5:	period = periods[2]; break; // Tỵ
			case 6:	period = periods[3]; break; // Ngọ
			case 7:	period = periods[4]; break; // Mùi
			case 8:	period = periods[5]; break; // Thân
			case 9:	period = periods[6]; break; // Dậu
			case 10: period = periods[7]; break; // Tuất
			case 11: period = periods[8]; break; // Hợi
		}
	} else if ((month == 4 && (day >= (5+leapDiff) && day <= 30)) || (month == 5 && (day >= 1 && day < (6+leapDiff)))) { // Sau thanh minh
		switch(branchIndex) {
			case 0:	period = periods[8]; break; // Tý
			case 1:	period = periods[9]; break; // Sửu
			case 2:	period = periods[10]; break; // Dần
			case 3:	period = periods[11]; break; // Mẹo
			case 4:	period = periods[0]; break; // Thìn
			case 5:	period = periods[1]; break; // Tỵ
			case 6:	period = periods[2]; break; // Ngọ
			case 7:	period = periods[3]; break; // Mùi
			case 8:	period = periods[4]; break; // Thân
			case 9:	period = periods[5]; break; // Dậu
			case 10: period = periods[6]; break; // Tuất
			case 11: period = periods[7]; break; // Hợi
		}
	} else if ((month == 5 && (day >= (6+leapDiff) && day <= 31)) || (month == 6 && (day >= 1 && day < (6+leapDiff)))) { // Sau lập hạ
		switch(branchIndex) {
			case 0:	period = periods[7]; break; // Tý
			case 1:	period = periods[8]; break; // Sửu
			case 2:	period = periods[9]; break; // Dần
			case 3:	period = periods[10]; break; // Mẹo
			case 4:	period = periods[11]; break; // Thìn
			case 5:	period = periods[0]; break; // Tỵ
			case 6:	period = periods[1]; break; // Ngọ
			case 7:	period = periods[2]; break; // Mùi
			case 8:	period = periods[3]; break; // Thân
			case 9:	period = periods[4]; break; // Dậu
			case 10: period = periods[5]; break; // Tuất
			case 11: period = periods[6]; break; // Hợi
		}
	} else if ((month == 6 && (day >= (6+leapDiff) && day <= 30)) || (month == 7 && (day >= 1 && day < (7+leapDiff)))) { // Sau mang chủng
		switch(branchIndex) {
			case 0:	period = periods[6]; break; // Tý
			case 1:	period = periods[7]; break; // Sửu
			case 2:	period = periods[8]; break; // Dần
			case 3:	period = periods[9]; break; // Mẹo
			case 4:	period = periods[10]; break; // Thìn
			case 5:	period = periods[11]; break; // Tỵ
			case 6:	period = periods[0]; break; // Ngọ
			case 7:	period = periods[1]; break; // Mùi
			case 8:	period = periods[2]; break; // Thân
			case 9:	period = periods[3]; break; // Dậu
			case 10: period = periods[4]; break; // Tuất
			case 11: period = periods[5]; break; // Hợi
		}
	} else if ((month == 7 && (day >= (7+leapDiff) && day <= 31)) || (month == 8 && (day >= 1 && day < (8+leapDiff)))) { // Sau tiểu thử
		switch(branchIndex) {
			case 0:	period = periods[5]; break; // Tý
			case 1:	period = periods[6]; break; // Sửu
			case 2:	period = periods[7]; break; // Dần
			case 3:	period = periods[8]; break; // Mẹo
			case 4:	period = periods[9]; break; // Thìn
			case 5:	period = periods[10]; break; // Tỵ
			case 6:	period = periods[11]; break; // Ngọ
			case 7:	period = periods[0]; break; // Mùi
			case 8:	period = periods[1]; break; // Thân
			case 9:	period = periods[2]; break; // Dậu
			case 10: period = periods[3]; break; // Tuất
			case 11: period = periods[4]; break; // Hợi
		}
	} else if ((month == 8 && (day >= (8+leapDiff) && day <= 31)) || (month == 9 && (day >= 1 && day < (8+leapDiff)))) { // Sau lập thu
		switch(branchIndex) {
			case 0:	period = periods[4]; break; // Tý
			case 1:	period = periods[5]; break; // Sửu
			case 2:	period = periods[6]; break; // Dần
			case 3:	period = periods[7]; break; // Mẹo
			case 4:	period = periods[8]; break; // Thìn
			case 5:	period = periods[9]; break; // Tỵ
			case 6:	period = periods[10]; break; // Ngọ
			case 7:	period = periods[11]; break; // Mùi
			case 8:	period = periods[0]; break; // Thân
			case 9:	period = periods[1]; break; // Dậu
			case 10: period = periods[2]; break; // Tuất
			case 11: period = periods[3]; break; // Hợi
		}
	} else if ((month == 9 && (day >= (8+leapDiff) && day <= 30)) || (month == 10 && (day >= 1 && day < (8+leapDiff)))) { // Sau bạch lộ
		switch(branchIndex) {
			case 0:	period = periods[3]; break; // Tý
			case 1:	period = periods[4]; break; // Sửu
			case 2:	period = periods[5]; break; // Dần
			case 3:	period = periods[6]; break; // Mẹo
			case 4:	period = periods[7]; break; // Thìn
			case 5:	period = periods[8]; break; // Tỵ
			case 6:	period = periods[9]; break; // Ngọ
			case 7:	period = periods[10]; break; // Mùi
			case 8:	period = periods[11]; break; // Thân
			case 9:	period = periods[0]; break; // Dậu
			case 10: period = periods[1]; break; // Tuất
			case 11: period = periods[2]; break; // Hợi
		}
	} else if ((month == 10 && (day >= (8+leapDiff) && day <= 30)) || (month == 11 && (day >= 1 && day < (8+leapDiff)))) { // Sau hàn lộ
		switch(branchIndex) {
			case 0:	period = periods[2]; break; // Tý
			case 1:	period = periods[3]; break; // Sửu
			case 2:	period = periods[4]; break; // Dần
			case 3:	period = periods[5]; break; // Mẹo
			case 4:	period = periods[6]; break; // Thìn
			case 5:	period = periods[7]; break; // Tỵ
			case 6:	period = periods[8]; break; // Ngọ
			case 7:	period = periods[9]; break; // Mùi
			case 8:	period = periods[10]; break; // Thân
			case 9:	period = periods[11]; break; // Dậu
			case 10: period = periods[0]; break; // Tuất
			case 11: period = periods[1]; break; // Hợi
		}
	} else if ((month == 11 && (day >= (8+leapDiff) && day <= 30)) || (month == 12 && (day >= 1 && day < (7+leapDiff)))) { // Sau lập đông
		switch(branchIndex) {
			case 0:	period = periods[1]; break; // Tý
			case 1:	period = periods[2]; break; // Sửu
			case 2:	period = periods[3]; break; // Dần
			case 3:	period = periods[4]; break; // Mẹo
			case 4:	period = periods[5]; break; // Thìn
			case 5:	period = periods[6]; break; // Tỵ
			case 6:	period = periods[7]; break; // Ngọ
			case 7:	period = periods[8]; break; // Mùi
			case 8:	period = periods[9]; break; // Thân
			case 9:	period = periods[10]; break; // Dậu
			case 10: period = periods[11]; break; // Tuất
			case 11: period = periods[0]; break; // Hợi
		}
	} else if ((month == 12 && (day >= (7+leapDiff) && day <= 31)) || (month == 1 && (day >= 1 && day < (6+leapDiff)))) { // Sau đại tuyết
		switch(branchIndex) {
			case 0:	period = periods[0]; break; // Tý
			case 1:	period = periods[1]; break; // Sửu
			case 2:	period = periods[2]; break; // Dần
			case 3:	period = periods[3]; break; // Mẹo
			case 4:	period = periods[4]; break; // Thìn
			case 5:	period = periods[5]; break; // Tỵ
			case 6:	period = periods[6]; break; // Ngọ
			case 7:	period = periods[7]; break; // Mùi
			case 8:	period = periods[8]; break; // Thân
			case 9:	period = periods[9]; break; // Dậu
			case 10: period = periods[10]; break; // Tuất
			case 11: period = periods[11]; break; // Hợi
		}
	} else if ((month == 1 && (day >= (6+leapDiff) && day <= 31)) || (month == 2 && (day >= 1 && day < (4+leapDiff)))) { // Sau tiểu hàn
		switch(branchIndex) {
			case 0:	period = periods[11]; break; // Tý
			case 1:	period = periods[0]; break; // Sửu
			case 2:	period = periods[1]; break; // Dần
			case 3:	period = periods[2]; break; // Mẹo
			case 4:	period = periods[3]; break; // Thìn
			case 5:	period = periods[4]; break; // Tỵ
			case 6:	period = periods[5]; break; // Ngọ
			case 7:	period = periods[6]; break; // Mùi
			case 8:	period = periods[7]; break; // Thân
			case 9:	period = periods[8]; break; // Dậu
			case 10: period = periods[9]; break; // Tuất
			case 11: period = periods[10]; break; // Hợi
		}
	}
	return period;
}
var goodStars = ['Địa tài (cầu tài lộc, khai trương)','Lục hợp (tốt mọi việc)','Thiên giải','Thiên hỷ (cưới hỏi)','Thiên quý (yếu yên)','Tam hợp (tốt mọi việc)','Sinh khí (thuận việc làm nhà, sửa nhà, động thổ)','Thiên thành (cưới gả, giao dịch)','Thiên quan (xuất hành giao dịch tốt)','Lộc mã (xuất hành di chuyển tốt)','Phúc sinh (tốt mọi việc)','Giải thần (giải trừ các sao xấu)','Thiên ân (làm nhà, khai trương)','Dịch mã (xuất hành)','Mẫu thương (cầu tài, khai trương)','Thiên phúc (tốt mọi việc)','Phúc hậu (cầu tài, khai trương)','Đại hồng sa (tốt mọi việc)','Thời đức (tốt mọi việc)','Thiên tài (cầu tài lộc, khai trương)','Nguyệt tài (cầu tài lộc, khai trương, xuất hành, di chuyển, giao dịch)','Nguyệt ân (cầu tài lộc, khai trương, xuất hành, di chuyển, giao dịch)','Thiên đức hợp (tốt mọi việc)','Thiên đức (tốt mọi việc)','Nguyệt đức (tốt mọi việc)','Nguyệt đức hợp (tốt mọi việc, kỵ kiện tụng)','Thiên phú (xây dựng, khai trương, an táng)','Nguyệt không (sửa nhà, đặt giường)','Thánh tâm (cầu phúc, tế tự)','Ngũ phú (tốt mọi việc)','Cát khánh (tốt mọi việc)'];
var badStars = ['Thiên cương (xấu mọi việc)','Thụ tử','Đại hao','Tử khí','Quan phù (xấu trong mọi việc lớn)','Tiểu hao (kỵ xuất nhập, tiền tài)','Sát chủ','Thiên hỏa','Địa hỏa','Hỏa tai','Nguyệt phá (kiêng làm nhà)','Băng tiêu ngọa giải (kiêng làm nhà và mọi việc lớn)','Thổ cấm (kiêng động thổ)','Vãng vong (kiêng xuất hành giá thú)','Cô thần','Quả tú (kiêng giá thú)','Trùng tang (kỵ hôn nhân, mai táng, cải táng)','Trùng phục (kỵ hôn nhân, mai táng, cải táng)','Nguyệt kỵ','Tam nương','Phi ma sát (kỵ nhập trạch, giá thú)','Ngũ quỷ (kỵ xuất hành)','Hà khôi (kỵ khởi công xây nhà)','Thiên lại (xấu mọi việc)','Tiểu hồng sa (xấu mọi việc)'];
function getStars(date) {
	var starsList = [];
	var lunarDate = getLunarDate(date);
	var lunarMonth = lunarDate[1];
	var lunarDay = lunarDate[0];
	var date = new Date(date);
	var solarYear = date.getFullYear();
	var solarMonth = date.getMonth()+1;
	var solarDay = date.getDate();
	var jd = jdFromDate(solarDay,solarMonth,solarYear);
	var dayStemIndex = (jd+9)%10;
	var dayBranchIndex = (jd+1)%12;
	if (lunarDay == 5 || lunarDay == 14 || lunarDay == 23) {
		starsList.push(badStars[18]);
	}
	if (lunarDay == 3 || lunarDay == 7 || lunarDay == 13 || lunarDay == 18 || lunarDay == 22 || lunarDay == 27) {
		starsList.push(badStars[19]);
	}
	/*
	case 0:	stem = 'Giáp'; break;
	case 1:	stem = 'Ất'; break;
	case 2:	stem = 'Bính'; break;
	case 3:	stem = 'Đinh'; break;
	case 4:	stem = 'Mậu'; break;
	case 5:	stem = 'Kỷ'; break;
	case 6:	stem = 'Canh'; break;
	case 7:	stem = 'Tân'; break;
	case 8:	stem = 'Nhâm'; break;
	case 9:	stem = 'Quý'; break;
	*/
	switch (lunarMonth) {
		// Tháng Giêng
		case 1:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[6],goodStars[14],goodStars[17],badStars[6],badStars[7],badStars[20]); break; // Ngày Tý: Sinh khí, Mẫu thương, Đại hồng sa, Sát chủ, Thiên hỏa, Phi ma sát
				case 1:	starsList.push(goodStars[17],badStars[9]); break; // Ngày Sửu: Đại hồng sa, Hỏa tai
				case 2:	starsList.push(goodStars[4],goodStars[16],badStars[13]); break; // Ngày Dần: Thiên quý, Phúc hậu, Vãng vong
				case 4:	starsList.push(goodStars[19],goodStars[26],badStars[15]); break; // Ngày Thìn: Thiên tài, Thiên phú, Quả tú
				case 5:	starsList.push(goodStars[0],badStars[0],badStars[5],badStars[11],badStars[24]); break; // Ngày Tỵ: Địa tài, Thiên cương, Tiểu hao, Băng tiêu ngọa giải, Tiểu hồng sa
				case 6:	starsList.push(goodStars[2],goodStars[5],goodStars[9],goodStars[18],goodStars[20],badStars[2],badStars[3],badStars[4],badStars[21]); break; // Ngày Ngọ: Thiên giải, Tam hợp, Lộc mã, Thời đức, Nguyệt tài, Đại hao, Tử khí, Quan phù, Ngũ quỷ
				case 7:	starsList.push(goodStars[7]); break; // Ngày Mùi: Thiên thành
				case 8:	starsList.push(goodStars[11],goodStars[13],badStars[10]); break; // Ngày Thân: Giải thần, Dịch mã, Nguyệt phá
				case 9:	starsList.push(goodStars[10],goodStars[30],badStars[23]); break; // Ngày Dậu: Phúc sinh, Cát khánh, Thiên lại
				case 10: starsList.push(goodStars[3],goodStars[5],goodStars[8],goodStars[12],badStars[1],badStars[8],badStars[14]); break; // Ngày Tuất: Thiên hỷ, Tam hợp, Thiên quan, Thiên ân, Thụ tử, Địa hỏa, Cô thần
				case 11: starsList.push(goodStars[1],goodStars[14],goodStars[28],goodStars[29],badStars[12],badStars[22]); break; // Ngày Hợi: Lục hợp, Mẫu thương, Thánh tâm, Ngũ phú, Thổ cấm, Hà khôi
			}
			switch (dayStemIndex) {
				case 0: starsList.push(badStars[16]); break; // Giáp: Trùng tang
				case 2: starsList.push(goodStars[21],goodStars[24]); break; // Bính: Nguyệt ân, Nguyệt đức
				case 3: starsList.push(goodStars[23]); break; // Đinh: Thiên đức
				case 5: starsList.push(goodStars[15]); break; // Kỷ: Thiên phúc
				case 6: starsList.push(badStars[17]); break; // Canh: Trùng phục
				case 7: starsList.push(goodStars[25]); break; // Tân: Nguyệt đức hợp
				case 8: starsList.push(goodStars[22],goodStars[27]); break; // Nhâm: Thiên đức hợp, Nguyệt không
			}
			break;
		// Tháng Hai
		case 2:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[8],goodStars[14],goodStars[17],badStars[0],badStars[11]); break; // Ngày Tý: Thiên quan, Mẫu thương, Đại hồng sa, Thiên cương, Băng tiêu ngọa giải
				case 1:	starsList.push(goodStars[6],goodStars[12],goodStars[17]); break; // Ngày Sửu: Sinh khí, Thiên ân, Đại hồng sa
				case 2:	starsList.push(goodStars[16],goodStars[29],goodStars[30],badStars[21]); break; // Ngày Dần: Phúc hậu, Ngũ phú, Cát khánh, Ngũ quỷ
				case 3:	starsList.push(goodStars[10],badStars[7]); break; // Ngày Mẹo: Phúc sinh, Thiên hỏa
				case 4:	starsList.push(badStars[1]); break; // Ngày Thìn: Thụ tử
				case 5:	starsList.push(goodStars[13],goodStars[20],goodStars[22],goodStars[26],goodStars[28],badStars[6],badStars[13],badStars[15]); break; // Ngày Tỵ: Dịch mã, Nguyệt tài, Thiên đức hợp, Thiên phú, Thánh tâm, Sát chủ, Vãng vong, Quả tú
				case 6:	starsList.push(goodStars[18],goodStars[19],badStars[5],badStars[22],badStars[23]); break; // Ngày Ngọ: Thời đức, Thiên tài, Tiểu hao, Hà khôi, Thiên lại
				case 7:	starsList.push(goodStars[0],goodStars[5],badStars[2],badStars[3],badStars[4],badStars[9]); break; // Ngày Mùi: Địa tài, Tam hợp, Đại hao, Tử khí, Quan phù, Hỏa tai
				case 8:	starsList.push(goodStars[2],goodStars[4],goodStars[9],goodStars[11],goodStars[23]); break; // Ngày Thân: Thiên giải, Thiên quý, Lộc mã, Giải thần, Thiên đức
				case 9:	starsList.push(goodStars[7],badStars[8],badStars[20],badStars[24]); break; // Ngày Dậu: Thiên thành, Địa hỏa, Phi ma sát, Tiểu hồng sa
				case 10: starsList.push(goodStars[1],badStars[10]); break; // Ngày Tuất: Lục hợp, Nguyệt phá
				case 11: starsList.push(goodStars[3],goodStars[5],goodStars[14],badStars[12],badStars[14]); break; // Ngày Hợi: Thiên hỷ, Tam hợp, Mẫu thương, Thổ cấm, Cô thần
			}
			switch (dayStemIndex) {
				case 0: starsList.push(goodStars[24]); break; // Giáp: Nguyệt đức
				case 1: starsList.push(badStars[16]); break; // Ất: Trùng tang
				case 3: starsList.push(goodStars[21]); break; // Đinh: Nguyệt ân
				case 4: starsList.push(goodStars[15]); break; // Mậu: Thiên phúc
				case 5: starsList.push(goodStars[25]); break; // Kỷ: Nguyệt đức hợp
				case 6: starsList.push(goodStars[27]); break; // Canh: Nguyệt không
				case 7: starsList.push(badStars[17]); break; // Tân: Trùng phục
			}
			break;
		// Tháng Ba
		case 3:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[3],goodStars[5],goodStars[14],goodStars[17],goodStars[28],badStars[14]); break; // Ngày Tý: Thiên hỷ, Tam hợp, Mẫu thương, Đại hồng sa, Thánh tâm, Cô thần
				case 1:	starsList.push(goodStars[17],badStars[11],badStars[22],badStars[24]); break; // Ngày Sửu: Đại hồng sa, Băng tiêu ngọa giải, Hà khôi, Tiểu hồng sa
				case 2:	starsList.push(goodStars[6],goodStars[8],goodStars[12],goodStars[13],goodStars[16],badStars[9]); break; // Ngày Dần: Sinh khí, Thiên quan, Thiên ân, Dịch mã, Phúc hậu, Hỏa tai
				case 3:	starsList.push(goodStars[4],badStars[23]); break; // Ngày Mẹo: Thiên quý, Thiên lại
				case 4:	starsList.push(badStars[21]); break; // Ngày Thìn: Ngũ quỷ
				case 5:	starsList.push(goodStars[20],goodStars[29]); break; // Ngày Tỵ: Nguyệt tài, Ngũ phú
				case 6:	starsList.push(goodStars[18],goodStars[26],badStars[7],badStars[15],badStars[20]); break; // Ngày Ngọ: Thời đức, Thiên phú, Thiên hỏa, Quả tú, Phi ma sát
				case 7:	starsList.push(badStars[0],badStars[5],badStars[6]); break; // Ngày Mùi: Thiên cương, Tiểu hao, Sát chủ
				case 8:	starsList.push(goodStars[5],goodStars[19],badStars[2],badStars[3],badStars[4],badStars[8],badStars[13]); break; // Ngày Thân: Tam hợp, Thiên tài, Đại hao, Tử khí, Quan phù, Địa hỏa, Vãng vong
				case 9:	starsList.push(goodStars[0],goodStars[1]); break; // Ngày Dậu: Địa tài, Lục hợp
				case 10: starsList.push(goodStars[2],goodStars[9],goodStars[10],goodStars[11],badStars[10]); break; // Ngày Tuất: Thiên giải, Lộc mã, Phúc sinh, Giải thần, Nguyệt phá
				case 11: starsList.push(goodStars[7],goodStars[14],goodStars[30],badStars[1],badStars[12]); break; // Ngày Hợi: Thiên thành, Mẫu thương, Cát khánh, Thụ tử, Thổ cấm
			}
			switch (dayStemIndex) {
				case 2: starsList.push(goodStars[27]); break; // Bính: Nguyệt không
				case 3: starsList.push(goodStars[22],goodStars[25]); break; // Đinh: Thiên đức hợp, Nguyệt đức hợp
				case 4: starsList.push(badStars[16]); break; // Mậu: Trùng tang
				case 5: starsList.push(badStars[17]); break; // Kỷ: Trùng phục
				case 6: starsList.push(goodStars[21]); break; // Canh: Nguyệt ân
				case 8: starsList.push(goodStars[23],goodStars[24]); break; // Nhâm: Thiên đức, Nguyệt đức
			}
			break;
		// Tháng Tư
		case 4:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[2],goodStars[9],badStars[23]); break; // Ngày Tý: Thiên giải, Lộc mã, Thiên lại
				case 1:	starsList.push(goodStars[3],goodStars[5],goodStars[7],badStars[14]); break; // Ngày Sửu: Thiên hỷ, Tam hợp, Thiên thành, Cô thần
				case 2:	starsList.push(goodStars[14],badStars[0],badStars[12]); break; // Ngày Dần: Mẫu thương, Thiên cương, Thổ cấm
				case 3:	starsList.push(goodStars[6],goodStars[14],badStars[6],badStars[20]); break; // Ngày Mẹo: Sinh khí, Mẫu thương, Sát chủ, Phi ma sát
				case 4:	starsList.push(goodStars[8],goodStars[10],goodStars[17],goodStars[30]); break; // Ngày Thìn: Thiên quan, Phúc sinh, Đại hồng sa, Cát khánh
				case 5:	starsList.push(goodStars[12],goodStars[16],goodStars[17],badStars[1],badStars[24]); break; // Ngày Tỵ: Thiên ân, Phúc hậu, Đại hồng sa, Thụ tử, Tiểu hồng sa
				case 6:	starsList.push(goodStars[28]); break; // Ngày Ngọ: Thánh tâm
				case 7:	starsList.push(goodStars[20],goodStars[26],badStars[8],badStars[15]); break; // Ngày Mùi: Nguyệt tài, Thiên phú, Địa hỏa, Quả tú
				case 8:	starsList.push(goodStars[1],goodStars[29],badStars[5],badStars[9],badStars[11],badStars[22]); break; // Ngày Thân: Lục hợp, Ngũ phú, Tiểu hao, Hỏa tai, Băng tiêu ngọa giải, Hà khôi
				case 9:	starsList.push(goodStars[4],goodStars[5],goodStars[18],badStars[2],badStars[3],badStars[4],badStars[7],badStars[21]); break; // Ngày Dậu: Thiên quý, Tam hợp, Thời đức, Đại hao, Tử khí, Quan phù, Thiên hỏa, Ngũ quỷ
				case 10: starsList.push(goodStars[11],goodStars[19]); break; // Ngày Tuất: Giải thần, Thiên tài
				case 11: starsList.push(goodStars[0],goodStars[13],badStars[10],badStars[13]); break; // Ngày Hợi: Địa tài, Dịch mã, Nguyệt phá, Vãng vong
			}
			switch (dayStemIndex) {
				case 0: starsList.push(goodStars[27]); break; // Giáp: Nguyệt không
				case 1: starsList.push(goodStars[25]); break; // Ất: Nguyệt đức hợp
				case 2: starsList.push(goodStars[22],badStars[16]); break; // Bính: Thiên đức hợp, Trùng tang
				case 5: starsList.push(goodStars[21]); break; // Kỷ: Nguyệt ân
				case 6: starsList.push(goodStars[24]); break; // Canh: Nguyệt đức
				case 7: starsList.push(goodStars[15],goodStars[23]); break; // Tân: Thiên phúc, Thiên đức
				case 8: starsList.push(badStars[17]); break; // Nhâm: Trùng phục
			}
			break;
		// Tháng Năm
		case 5:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[11],goodStars[19],badStars[1],badStars[7],badStars[20]); break; // Ngày Tý: Giải thần, Thiên tài, Thụ tử, Thiên hỏa, Phi ma sát
				case 1:	starsList.push(goodStars[0],goodStars[28],goodStars[30],badStars[10]); break; // Ngày Sửu: Địa tài, Thánh tâm, Cát khánh, Nguyệt phá
				case 2:	starsList.push(goodStars[2],goodStars[3],goodStars[5],goodStars[9],goodStars[14],goodStars[22],badStars[12],badStars[14]); break; // Ngày Dần: Thiên giải, Thiên hỷ, Tam hợp, Lộc mã, Mẫu thương, Thiên đức hợp, Thổ cấm, Cô thần
				case 3:	starsList.push(goodStars[7],goodStars[14],badStars[9],badStars[11],badStars[13],badStars[21],badStars[22]); break; // Ngày Mẹo: Thiên thành, Mẫu thương, Hỏa tai, Băng tiêu ngọa giải, Vãng vong, Ngũ quỷ, Hà khôi
				case 4:	starsList.push(goodStars[4],goodStars[6],goodStars[17]); break; // Ngày Thìn: Thiên quý, Sinh khí, Đại hồng sa
				case 5:	starsList.push(goodStars[16],goodStars[17]); break; // Ngày Tỵ: Phúc hậu, Đại hồng sa
				case 6:	starsList.push(goodStars[8],badStars[8]); break; // Ngày Ngọ: Thiên quan, Địa hỏa
				case 7:	starsList.push(goodStars[1]); break; // Ngày Mùi: Lục hợp
				case 8:	starsList.push(goodStars[13],goodStars[26],badStars[6],badStars[15]); break; // Ngày Thân: Dịch mã, Thiên phú, Sát chủ, Quả tú
				case 9:	starsList.push(goodStars[12],goodStars[18],goodStars[20],badStars[0],badStars[5],badStars[23],badStars[24]); break; // Ngày Dậu: Thiên ân, Thời đức, Nguyệt tài, Thiên cương, Tiểu hao, Thiên lại, Tiểu hồng sa
				case 10: starsList.push(goodStars[5],badStars[2],badStars[3],badStars[4]); break; // Ngày Tuất: Tam hợp, Đại hao, Tử khí, Quan phù
				case 11: starsList.push(goodStars[10],goodStars[23],goodStars[29]); break; // Ngày Hợi: Phúc sinh, Thiên đức, Ngũ phú
			}
			switch (dayStemIndex) {
				case 2: starsList.push(goodStars[24]); break; // Bính: Nguyệt đức
				case 3: starsList.push(badStars[16]); break; // Đinh: Trùng tang
				case 4: starsList.push(goodStars[21]); break; // Mậu: Nguyệt ân
				case 6: starsList.push(goodStars[15]); break; // Canh: Thiên phúc
				case 7: starsList.push(goodStars[25]); break; // Tân: Nguyệt đức hợp
				case 8: starsList.push(goodStars[15],goodStars[27]); break; // Nhâm: Thiên phúc, Nguyệt không
				case 9: starsList.push(badStars[17]); break; // Quý: Trùng phục
			}
			break;
		// Tháng Sáu
		case 6:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[11]); break; // Ngày Tý: Giải thần
				case 1:	starsList.push(badStars[10],badStars[24]); break; // Ngày Sửu: Nguyệt phá, Tiểu hồng sa
				case 2:	starsList.push(goodStars[14],goodStars[19],goodStars[29],badStars[12]); break; // Ngày Dần: Mẫu thương, Thiên tài, Ngũ phú, Thổ cấm
				case 3:	starsList.push(goodStars[0],goodStars[3],goodStars[5],goodStars[12],goodStars[14],badStars[7],badStars[14]); break; // Ngày Mẹo: Địa tài, Thiên hỷ, Tam hợp, Thiên ân, Mẫu thương, Thiên hỏa, Cô thần
				case 4:	starsList.push(goodStars[2],goodStars[9],goodStars[17],badStars[0]); break; // Ngày Thìn: Thiên giải, Lộc mã, Đại hồng sa, Thiên cương
				case 5:	starsList.push(goodStars[6],goodStars[7],goodStars[10],goodStars[13],goodStars[16],goodStars[17],badStars[8]); break; // Ngày Tỵ: Sinh khí, Thiên thành, Phúc sinh, Dịch mã, Phúc hậu, Đại hồng sa, Địa hỏa
				case 6:	starsList.push(goodStars[1],goodStars[30],badStars[1],badStars[13],badStars[23]); break; // Ngày Ngọ: Lục hợp, Cát khánh, Thụ tử, Vãng vong, Thiên lại
				case 7:	starsList.push(goodStars[28]); break; // Ngày Mùi: Thánh tâm
				case 8:	starsList.push(goodStars[8],badStars[21]); break; // Ngày Thân: Thiên quan, Ngũ quỷ
				case 9:	starsList.push(goodStars[18],goodStars[26],badStars[9],badStars[15],badStars[20]); break; // Ngày Dậu: Thời đức, Thiên phú, Hỏa tai, Quả tú, Phi ma sát
				case 10: starsList.push(goodStars[4],badStars[5],badStars[6],badStars[11],badStars[22]); break; // Ngày Tuất: Thiên quý, Tiểu hao, Sát chủ, Băng tiêu ngọa giải, Hà khôi
				case 11: starsList.push(goodStars[5],goodStars[20],badStars[2],badStars[3],badStars[4]); break; // Ngày Hợi: Tam hợp, Nguyệt tài, Đại hao, Tử khí, Quan phù
			}
			switch (dayStemIndex) {
				case 0: starsList.push(goodStars[23],goodStars[24]); break; // Giáp: Thiên đức, Nguyệt đức
				case 4: starsList.push(badStars[17]); break; // Mậu: Trùng phục
				case 5: starsList.push(goodStars[22],goodStars[25],badStars[16]); break; // Kỷ: Thiên đức hợp, Nguyệt đức hợp, Trùng tang
				case 6: starsList.push(goodStars[27]); break; // Canh: Nguyệt không
				case 7: starsList.push(goodStars[21]); break; // Tân: Nguyệt ân
			}
			break;
		// Tháng Bảy
		case 7:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[5],goodStars[10],goodStars[12],goodStars[18],badStars[2],badStars[3],badStars[4]); break; // Ngày Tý: Tam hợp, Phúc sinh, Thiên ân, Thời đức, Đại hao, Tử khí, Quan phù
				case 1:	starsList.push(goodStars[14],badStars[1],badStars[6],badStars[21]); break; // Ngày Sửu: Mẫu thương, Thụ tử, Sát chủ, Ngũ quỷ
				case 2:	starsList.push(goodStars[11],goodStars[13],goodStars[28],badStars[10]); break; // Ngày Dần: Giải thần, Dịch mã, Thánh tâm, Nguyệt phá
				case 3:	starsList.push(goodStars[30],badStars[23]); break; // Ngày Mẹo: Cát khánh, Thiên lại
				case 4:	starsList.push(goodStars[3],goodStars[5],goodStars[14],goodStars[19],badStars[8],badStars[9],badStars[14]); break; // Ngày Thìn: Thiên hỷ, Tam hợp, Mẫu thương, Thiên tài, Địa hỏa, Hỏa tai, Cô thần
				case 5:	starsList.push(goodStars[0],goodStars[1],goodStars[4],goodStars[29],badStars[12],badStars[22],badStars[24]); break; // Ngày Tỵ: Địa tài, Lục hợp, Thiên quý, Ngũ phú, Thổ cấm, Hà khôi, Tiểu hồng sa
				case 6:	starsList.push(goodStars[2],goodStars[6],goodStars[9],goodStars[17],goodStars[20],badStars[7],badStars[20]); break; // Ngày Ngọ: Thiên giải, Sinh khí, Lộc mã, Đại hồng sa, Nguyệt tài, Thiên hỏa, Phi ma sát
				case 7:	starsList.push(goodStars[7],goodStars[17]); break; // Ngày Mùi: Thiên thành, Đại hồng sa
				case 8:	starsList.push(goodStars[16]); break; // Ngày Thân: Phúc hậu
				case 9:	starsList.push(badStars[13]); break; // Ngày Dậu: Vãng vong
				case 10: starsList.push(goodStars[8],goodStars[26],badStars[15]); break; // Ngày Tuất: Thiên quan, Thiên phú, Quả tú
				case 11: starsList.push(badStars[0],badStars[5],badStars[11]); break; // Ngày Hợi: Thiên cương, Tiểu hao, Băng tiêu ngọa giải
			}
			switch (dayStemIndex) {
				case 0: starsList.push(badStars[17]); break; // Giáp: Trùng phục
				case 1: starsList.push(goodStars[15]); break; // Ất: Thiên phúc
				case 2: starsList.push(goodStars[27]); break; // Bính: Nguyệt không
				case 3: starsList.push(goodStars[25]); break; // Đinh: Nguyệt đức hợp
				case 4: starsList.push(goodStars[22]); break; // Mậu: Thiên đức hợp
				case 6: starsList.push(badStars[16]); break; // Canh: Trùng tang
				case 8: starsList.push(goodStars[21],goodStars[24]); break; // Nhâm: Nguyệt ân, Nguyệt đức
				case 9: starsList.push(goodStars[23]); break; // Quý: Thiên đức
			}
			break;
		// Tháng Tám
		case 8:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[8],goodStars[18],badStars[5],badStars[13],badStars[22],badStars[23]); break; // Ngày Tý: Thiên quan, Thời đức, Tiểu hao, Vãng vong, Hà khôi, Thiên lại
				case 1:	starsList.push(goodStars[5],goodStars[14],badStars[2],badStars[3],badStars[4]); break; // Ngày Sửu: Tam hợp, Mẫu thương, Đại hao, Tử khí, Quan phù
				case 2:	starsList.push(goodStars[11],goodStars[23]); break; // Ngày Dần: Giải thần, Thiên đức
				case 3:	starsList.push(badStars[8],badStars[20]); break; // Ngày Mẹo: Địa hỏa, Phi ma sát
				case 4:	starsList.push(goodStars[1],goodStars[14],badStars[10]); break; // Ngày Thìn: Lục hợp, Mẫu thương, Nguyệt phá
				case 5:	starsList.push(goodStars[3],goodStars[5],goodStars[20],badStars[12],badStars[14],badStars[21]); break; // Ngày Tỵ: Thiên hỷ, Tam hợp, Nguyệt tài, Thổ cấm, Cô thần, Ngũ quỷ
				case 6:	starsList.push(goodStars[10],goodStars[12],goodStars[17],goodStars[19],badStars[0],badStars[11]); break; // Ngày Ngọ: Phúc sinh, Thiên ân, Đại hồng sa, Thiên tài, Thiên cương, Băng tiêu ngọa giải
				case 7:	starsList.push(goodStars[0],goodStars[6],goodStars[17],badStars[1]); break; // Ngày Mùi: Địa tài, Sinh khí, Đại hồng sa, Thụ tử
				case 8:	starsList.push(goodStars[2],goodStars[9],goodStars[16],goodStars[28],goodStars[29],goodStars[30]); break; // Ngày Thân: Thiên giải, Lộc mã, Phúc hậu, Thánh tâm, Ngũ phú, Cát khánh
				case 9:	starsList.push(goodStars[7],badStars[7],badStars[24]); break; // Ngày Dậu: Thiên thành, Thiên hỏa, Tiểu hồng sa
				case 10: starsList.push(badStars[9]); break; // Ngày Tuất: Hỏa tai
				case 11: starsList.push(goodStars[4],goodStars[13],goodStars[22],goodStars[26],badStars[6],badStars[15]); break; // Ngày Hợi: Thiên quý, Dịch mã, Thiên đức hợp, Thiên phú, Sát chủ, Quả tú
			}
			switch (dayStemIndex) {
				case 0: starsList.push(goodStars[15],goodStars[27]); break; // Giáp: Thiên phúc, Nguyệt không
				case 1: starsList.push(goodStars[25],badStars[17]); break; // Ất: Nguyệt đức hợp, Trùng phục
				case 6: starsList.push(goodStars[24]); break; // Canh: Nguyệt đức
				case 7: starsList.push(badStars[16]); break; // Tân: Trùng tang
				case 9: starsList.push(goodStars[21]); break; // Quý: Nguyệt ân
			}
			break;
		// Tháng Chín
		case 9:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[18],goodStars[26],badStars[7],badStars[15],badStars[20],badStars[21]); break; // Ngày Tý: Thời đức, Thiên phú, Thiên hỏa, Quả tú, Phi ma sát, Ngũ quỷ
				case 1:	starsList.push(goodStars[10],goodStars[14],badStars[0],badStars[5],badStars[24]); break; // Ngày Sửu: Phúc sinh, Mẫu thương, Thiên cương, Tiểu hao, Tiểu hồng sa
				case 2:	starsList.push(goodStars[5],goodStars[8],badStars[1],badStars[2],badStars[3],badStars[4],badStars[8]); break; // Ngày Dần: Tam hợp, Thiên quan, Thụ tử, Đại hao, Tử khí, Quan phù, Địa hỏa
				case 3:	starsList.push(goodStars[1],goodStars[28]); break; // Ngày Mẹo: Lục hợp, Thánh tâm
				case 4:	starsList.push(goodStars[11],goodStars[14],badStars[10],badStars[13]); break; // Ngày Thìn: Giải thần, Mẫu thương, Nguyệt phá, Vãng vong
				case 5:	starsList.push(goodStars[20],goodStars[30],badStars[9],badStars[12]); break; // Ngày Tỵ: Nguyệt tài, Cát khánh, Hỏa tai, Thổ cấm
				case 6:	starsList.push(goodStars[3],goodStars[4],goodStars[5],goodStars[17],badStars[6],badStars[14]); break; // Ngày Ngọ: Thiên hỷ, Thiên quý, Tam hợp, Đại hồng sa, Sát chủ, Cô thần
				case 7:	starsList.push(goodStars[7],goodStars[17],badStars[11],badStars[22]); break; // Ngày Mùi: Thiên thành, Đại hồng sa, Băng tiêu ngọa giải, Hà khôi
				case 8:	starsList.push(goodStars[6],goodStars[12],goodStars[13],goodStars[16],goodStars[19]); break; // Ngày Thân: Sinh khí, Thiên ân, Dịch mã, Phúc hậu, Thiên tài
				case 9:	starsList.push(goodStars[0],badStars[23]); break; // Ngày Dậu: Địa tài, Thiên lại
				case 10: starsList.push(goodStars[2],goodStars[9]); break; // Ngày Tuất: Thiên giải, Lộc mã
				case 11: starsList.push(goodStars[29]); break; // Ngày Hợi: Ngũ phú
			}
			switch (dayStemIndex) {
				case 2: starsList.push(goodStars[23],goodStars[24]); break; // Bính: Thiên đức, Nguyệt đức
				case 5: starsList.push(badStars[16],badStars[17]); break; // Kỷ: Trùng tang, Trùng phục
				case 6: starsList.push(goodStars[21]); break; // Canh: Nguyệt ân
				case 7: starsList.push(goodStars[22],goodStars[25]); break; // Tân: Thiên đức hợp, Nguyệt đức hợp
				case 8: starsList.push(goodStars[27]); break; // Nhâm: Nguyệt không
			}
			break;
		// Tháng Mười
		case 10:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[2],goodStars[4],goodStars[9]); break; // Ngày Tý: Thiên giải, Thiên quý, Lộc mã
				case 1:	starsList.push(goodStars[7],goodStars[26],badStars[8],badStars[15]); break; // Ngày Sửu: Thiên thành, Thiên phú, Địa hỏa, Quả tú
				case 2:	starsList.push(goodStars[1],goodStars[29],badStars[5],badStars[11],badStars[22]); break; // Ngày Dần: Lục hợp, Ngũ phú, Tiểu hao, Băng tiêu ngọa giải, Hà khôi
				case 3:	starsList.push(goodStars[5],goodStars[18],badStars[2],badStars[3],badStars[4],badStars[7]); break; // Ngày Mẹo: Tam hợp, Thời đức, Đại hao, Tử khí, Quan phù, Thiên hỏa
				case 4:	starsList.push(goodStars[8],goodStars[11],goodStars[12]); break; // Ngày Thìn: Thiên quan, Giải thần, Thiên ân
				case 5:	starsList.push(goodStars[13],badStars[10],badStars[24]); break; // Ngày Tỵ: Dịch mã, Nguyệt phá, Tiểu hồng sa
				case 6:	starsList.push(badStars[23]); break; // Ngày Ngọ: Thiên lại
				case 7:	starsList.push(goodStars[3],goodStars[5],goodStars[10],goodStars[20],badStars[13],badStars[14]); break; // Ngày Mùi: Thiên hỷ, Tam hợp, Phúc sinh, Nguyệt tài, Vãng vong, Cô thần
				case 8:	starsList.push(goodStars[14],goodStars[17],badStars[0],badStars[1],badStars[12]); break; // Ngày Thân: Mẫu thương, Đại hồng sa, Thiên cương, Thụ tử, Thổ cấm
				case 9:	starsList.push(goodStars[6],goodStars[14],goodStars[28],badStars[6],badStars[20]); break; // Ngày Dậu: Sinh khí, Mẫu thương, Thánh tâm, Sát chủ, Phi ma sát
				case 10: starsList.push(goodStars[17],goodStars[19],goodStars[30]); break; // Ngày Tuất: Đại hồng sa, Thiên tài, Cát khánh
				case 11: starsList.push(goodStars[0],goodStars[16],badStars[9],badStars[21]); break; // Ngày Hợi: Địa tài, Phúc hậu, Hỏa tai, Ngũ quỷ
			}
			switch (dayStemIndex) {
				case 0: starsList.push(goodStars[24]); break; // Giáp: Nguyệt đức
				case 1: starsList.push(goodStars[21],goodStars[23]); break; // Ất: Nguyệt ân, Thiên đức
				case 2: starsList.push(badStars[17]); break; // Bính: Trùng phục
				case 3: starsList.push(goodStars[15]); break; // Đinh: Thiên phúc
				case 5: starsList.push(goodStars[25]); break; // Kỷ: Nguyệt đức hợp
				case 6: starsList.push(goodStars[22],goodStars[27]); break; // Canh: Thiên đức hợp, Nguyệt không
				case 8: starsList.push(badStars[16]); break; // Nhâm: Trùng tang
			}
			break;
		// Tháng Mười một
		case 11:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[19],badStars[8],badStars[9]); break; // Ngày Tý: Thiên tài, Địa hỏa, Hỏa tai
				case 1:	starsList.push(goodStars[0],goodStars[1]); break; // Ngày Sửu: Địa tài, Lục hợp
				case 2:	starsList.push(goodStars[2],goodStars[9],goodStars[10],goodStars[13],goodStars[26],badStars[6],badStars[15]); break; // Ngày Dần: Thiên giải, Lộc mã, Phúc sinh, Dịch mã, Thiên phú, Sát chủ, Quả tú
				case 3:	starsList.push(goodStars[7],goodStars[18],badStars[0],badStars[1],badStars[5],badStars[23]); break; // Ngày Mẹo: Thiên thành, Thời đức, Thiên cương, Thụ tử, Tiểu hao, Thiên lại
				case 4:	starsList.push(goodStars[5],goodStars[28],badStars[2],badStars[3],badStars[4]); break; // Ngày Thìn: Tam hợp, Thánh tâm, Đại hao, Tử khí, Quan phù
				case 5:	starsList.push(goodStars[23],goodStars[29]); break; // Ngày Tỵ: Thiên đức, Ngũ phú
				case 6:	starsList.push(goodStars[8],goodStars[11],badStars[7],badStars[20]); break; // Ngày Ngọ: Thiên quan, Giải thần, Thiên hỏa, Phi ma sát
				case 7:	starsList.push(goodStars[4],goodStars[30],badStars[10],badStars[21]); break; // Ngày Mùi: Thiên quý, Cát khánh, Nguyệt phá, Ngũ quỷ
				case 8:	starsList.push(goodStars[3],goodStars[5],goodStars[12],goodStars[14],goodStars[17],goodStars[22],badStars[12],badStars[14]); break; // Ngày Thân: Thiên hỷ, Tam hợp, Thiên ân, Mẫu thương, Đại hồng sa, Thiên đức hợp, Thổ cấm, Cô thần
				case 9:	starsList.push(goodStars[14],goodStars[20],badStars[11],badStars[22],badStars[24]); break; // Ngày Dậu: Mẫu thương, Nguyệt tài, Băng tiêu ngọa giải, Hà khôi, Tiểu hồng sa
				case 10: starsList.push(goodStars[6],goodStars[17],badStars[13]); break; // Ngày Tuất: Sinh khí, Đại hồng sa, Vãng vong
				case 11: starsList.push(goodStars[16]); break; // Ngày Hợi: Phúc hậu
			}
			switch (dayStemIndex) {
				case 0: starsList.push(goodStars[21]); break; // Giáp: Nguyệt ân
				case 2: starsList.push(goodStars[15],goodStars[27]); break; // Bính: Thiên phúc, Nguyệt không
				case 3: starsList.push(goodStars[25],badStars[17]); break; // Đinh: Nguyệt đức hợp, Trùng phục
				case 8: starsList.push(goodStars[24]); break; // Nhâm: Nguyệt đức
				case 9: starsList.push(badStars[16]); break; // Quý: Trùng tang
			}
			break;
		// Tháng Chạp
		case 12:
			switch (dayBranchIndex) {
				case 0:	starsList.push(goodStars[1],goodStars[30],badStars[23]); break; // Ngày Tý: Lục hợp, Cát khánh, Thiên lại
				case 1:	starsList.push(goodStars[4],badStars[13],badStars[24]); break; // Ngày Sửu: Thiên quý, Vãng vong, Tiểu hồng sa
				case 2:	starsList.push(goodStars[19]); break; // Ngày Dần: Thiên tài
				case 3:	starsList.push(goodStars[0],goodStars[18],goodStars[26],badStars[15],badStars[20]); break; // Ngày Mẹo: Địa tài, Thời đức, Thiên phú, Quả tú, Phi ma sát
				case 4:	starsList.push(goodStars[2],goodStars[9],badStars[5],badStars[6],badStars[11],badStars[22]); break; // Ngày Thìn: Thiên giải, Lộc mã, Tiểu hao, Sát chủ, Băng tiêu ngọa giải, Hà khôi
				case 5:	starsList.push(goodStars[5],goodStars[7],badStars[2],badStars[3],badStars[4]); break; // Ngày Tỵ: Tam hợp, Thiên thành, Đại hao, Tử khí, Quan phù
				case 6:	starsList.push(goodStars[11],badStars[9]); break; // Ngày Ngọ: Giải thần, Hỏa tai
				case 7:	starsList.push(goodStars[12],badStars[10]); break; // Ngày Mùi: Thiên ân, Nguyệt phá
				case 8:	starsList.push(goodStars[8],goodStars[10],goodStars[14],goodStars[17],goodStars[29],badStars[12]); break; // Ngày Thân: Thiên quan, Phúc sinh, Mẫu thương, Đại hồng sa, Ngũ phú, Thổ cấm
				case 9:	starsList.push(goodStars[3],goodStars[5],goodStars[14],badStars[1],badStars[7],badStars[14]); break; // Ngày Dậu: Thiên hỷ, Tam hợp, Mẫu thương, Thụ tử, Thiên hỏa, Cô thần
				case 10: starsList.push(goodStars[17],goodStars[28],badStars[0],badStars[21]); break; // Ngày Tuất: Đại hồng sa, Thánh tâm, Thiên cương, Ngũ quỷ
				case 11: starsList.push(goodStars[6],goodStars[13],goodStars[16],goodStars[20],badStars[8]); break; // Ngày Hợi: Sinh khí, Dịch mã, Phúc hậu, Nguyệt tài, Địa hỏa
			}
			switch (dayStemIndex) {
				case 0: starsList.push(goodStars[27]); break; // Giáp: Nguyệt không
				case 1: starsList.push(goodStars[22],goodStars[25]); break; // Ất: Thiên đức hợp, Nguyệt đức hợp
				case 4: starsList.push(badStars[16],badStars[17]); break; // Mậu: Trùng tang, Trùng phục
				case 6: starsList.push(goodStars[23],goodStars[24]); break; // Canh: Thiên đức, Nguyệt đức
				case 7: starsList.push(goodStars[21]); break; // Tân: Nguyệt ân
			}
			break;
	}
	starsList.sort();
	return starsList;
}
function getGoodStars(date) {
	var starsList = getStars(date);
	var goodStarsList = [];
	var count = starsList.length;
	for (i = 0; i < count; ++i) {
		if ($.inArray(starsList[i],goodStars) != -1) {
			goodStarsList.push(starsList[i]);
		}
	}
	return goodStarsList;
}
function getBadStars(date) {
	var starsList = getStars(date);
	var goodStarsList = [];
	var count = starsList.length;
	for (i = 0; i < count; ++i) {
		if ($.inArray(starsList[i],badStars) != -1) {
			goodStarsList.push(starsList[i]);
		}
	}
	return goodStarsList;
}
function isGoodDate(date) { // Ngày Hoàng Đạo
	var lunarDate = getLunarDate(date);
	var lunarMonth = lunarDate[1];
	var lunarDay = lunarDate[0];
	var date = new Date(date);
	var solarYear = date.getFullYear();
	var solarMonth = date.getMonth()+1;
	var solarDay = date.getDate();
	var jd = jdFromDate(solarDay,solarMonth,solarYear);
	var dayBranchIndex = (jd+1)%12;
	if (
		((lunarMonth == 1 || lunarMonth == 7) && (dayBranchIndex == 0 || dayBranchIndex == 1 || dayBranchIndex == 5 || dayBranchIndex == 7)) // Tháng Giêng, Bảy Ngày Tý, Sửu, Tỵ, Mùi
		||
		((lunarMonth == 2 || lunarMonth == 8) && (dayBranchIndex == 2 || dayBranchIndex == 3 || dayBranchIndex == 7 || dayBranchIndex == 9)) // Tháng Hai, Tám Ngày Dần, Mẹo, Mùi, Dậu
		||
		((lunarMonth == 3 || lunarMonth == 9) && (dayBranchIndex == 4 || dayBranchIndex == 5 || dayBranchIndex == 9 || dayBranchIndex == 11)) // Tháng Ba, Chín Ngày Thìn, Tỵ, Dậu, Hợi
		||
		((lunarMonth == 4 || lunarMonth == 10) && (dayBranchIndex == 6 || dayBranchIndex == 7 || dayBranchIndex == 11 || dayBranchIndex == 1)) // Tháng Tư, Mười Ngày Ngọ, Mùi, Dậu, Sửu
		||
		((lunarMonth == 5 || lunarMonth == 11) && (dayBranchIndex == 8 || dayBranchIndex == 9 || dayBranchIndex == 1 || dayBranchIndex == 3)) // Tháng Năm, Mười Một Ngày Thân, Dậu, Sửu, Mẹo
		||
		((lunarMonth == 6 || lunarMonth == 12) && (dayBranchIndex == 10 || dayBranchIndex == 11 || dayBranchIndex == 3 || dayBranchIndex == 5)) // Tháng Sáu, Chạp Ngày Tuất, Hợi, Mẹo, Tỵ
		) {
		return true;
	} else {
		return false;
	}
}
function isBadDate(date) { // Ngày Hắc Đạo
	var lunarDate = getLunarDate(date);
	var lunarMonth = lunarDate[1];
	var lunarDay = lunarDate[0];
	var date = new Date(date);
	var solarYear = date.getFullYear();
	var solarMonth = date.getMonth()+1;
	var solarDay = date.getDate();
	var jd = jdFromDate(solarDay,solarMonth,solarYear);
	var dayBranchIndex = (jd+1)%12;
	if (
		((lunarMonth == 1 || lunarMonth == 7) && (dayBranchIndex == 3 || dayBranchIndex == 6 || dayBranchIndex == 9 || dayBranchIndex == 11)) // Tháng Giêng, Bảy Ngày Mẹo, Ngọ, Dậu, Hợi
		||
		((lunarMonth == 2 || lunarMonth == 8) && (dayBranchIndex == 5 || dayBranchIndex == 8 || dayBranchIndex == 11 || dayBranchIndex == 1)) // Tháng Hai, Tám Ngày Tỵ, Thân, Hợi, Sửu
		||
		((lunarMonth == 3 || lunarMonth == 9) && (dayBranchIndex == 7 || dayBranchIndex == 10 || dayBranchIndex == 1 || dayBranchIndex == 11)) // Tháng Ba, Chín Ngày Mùi, Tuất, Sửu, Hợi
		||
		((lunarMonth == 4 || lunarMonth == 10) && (dayBranchIndex == 9 || dayBranchIndex == 0 || dayBranchIndex == 3 || dayBranchIndex == 5)) // Tháng Tư, Mười Ngày Dậu, Tý, Mẹo, Tỵ
		||
		((lunarMonth == 5 || lunarMonth == 11) && (dayBranchIndex == 11 || dayBranchIndex == 2 || dayBranchIndex == 5 || dayBranchIndex == 3)) // Tháng Năm, Mười Một Ngày Hợi, Dần, Tỵ, Mùi
		||
		((lunarMonth == 6 || lunarMonth == 12) && (dayBranchIndex == 1 || dayBranchIndex == 4 || dayBranchIndex == 7 || dayBranchIndex == 5)) // Tháng Sáu, Chạp Ngày Sửu, Thìn, Mùi, Dậu
		) {
		return true;
	} else {
		return false;
	}
}
var lunarApp = angular.module('lunarApp', []);
lunarApp.controller('lunarController', ['$scope', function($scope) {
	$scope.lunarYear = function(){
		if (isset($scope.solarDate) && !isEmpty('#solarDate')){
			return getLunarYear($scope.solarDate);
		}
	}
	$scope.lunarMonth = function(){
		if (isset($scope.solarDate) && !isEmpty('#solarDate')){
			return getLunarMonth($scope.solarDate);
		}
	}
	$scope.lunarDay = function(){
		if (isset($scope.solarDate) && !isEmpty('#solarDate')){
			return getLunarDay($scope.solarDate);
		}
	}
	$scope.lunarPeriod = function(){
		if (isset($scope.solarDate) && !isEmpty('#solarDate')){
			return calculateLunarPeriod($scope.solarDate);
		}
	}
	$scope.lunarPeriodDate = function(){
		if (isset($scope.solarDate) && !isEmpty('#solarDate')){
			return calculateLunarPeriodDate($scope.solarDate);
		}
	}
	$scope.lunarRate = function(){
		if (isset($scope.solarDate) && !isEmpty('#solarDate')) {
			if (isGoodDate($scope.solarDate)) {
				return 'Ngày Hoàng đạo (tốt)';
			} else if (isBadDate($scope.solarDate)) {
				return 'Ngày Hắc đạo (xấu)';
			} else {
				return 'Ngày bình thường';
			}
		}
	}
	$scope.lunarGoodStars = function(){
		if (isset($scope.solarDate) && !isEmpty('#solarDate')) {
			var goodStarsList = getGoodStars($scope.solarDate);
			return goodStarsList.length > 0 ? goodStarsList.join('\n'): 'Không có';
		}
	}
	$scope.lunarBadStars = function(){
		if (isset($scope.solarDate) && !isEmpty('#solarDate')) {
			var badStarsList = getBadStars($scope.solarDate);
			return badStarsList.length > 0 ? badStarsList.join('\n'): 'Không có';
		}
	}
}]);