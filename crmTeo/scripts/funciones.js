var p_c=new Array();//Array de codigos de provincia
var p_n=new Array();//Array de nombres
 p_c[0]='*NuLo*'; p_n[0]='--Elegir';
 p_c[1]='01';p_n[1]='Álava';
 p_c[2]='02';p_n[2]='Albacete';
 p_c[3]='03';p_n[3]='Alicante';
 p_c[4]='04';p_n[4]='Almería';
 p_c[5]='33';p_n[5]='Asturias';
 p_c[6]='05';p_n[6]='Ávila';
 p_c[7]='06';p_n[7]='Badajoz';
 p_c[8]='07';p_n[8]='Baleares';
 p_c[9]='08';p_n[9]='Barcelona';
 p_c[10]='09';p_n[10]='Burgos';
 p_c[11]='10';p_n[11]='Cáceres';
 p_c[12]='11';p_n[12]='Cádiz';
 p_c[13]='39';p_n[13]='Cantabria';
 p_c[14]='12';p_n[14]='Castellón';
 p_c[15]='51';p_n[15]='Ceuta';
 p_c[16]='13';p_n[16]='Ciudad Real';
 p_c[17]='14';p_n[17]='Córdoba';
 p_c[18]='16';p_n[18]='Cuenca';
 p_c[19]='17';p_n[19]='Gerona';
 p_c[20]='18';p_n[20]='Granada';
 p_c[21]='19';p_n[21]='Guadalajara';
 p_c[22]='20';p_n[22]='Guipúzcoa';
 p_c[23]='21';p_n[23]='Huelva';
 p_c[24]='22';p_n[24]='Huesca';
 p_c[25]='23';p_n[25]='Jaén';
 p_c[26]='15';p_n[26]='La Coruña';
 p_c[27]='26';p_n[27]='La Rioja';
 p_c[28]='35';p_n[28]='Las Palmas';
 p_c[29]='24';p_n[29]='León';
 p_c[30]='25';p_n[30]='Lérida';
 p_c[31]='27';p_n[31]='Lugo';
 p_c[32]='28';p_n[32]='Madrid';
 p_c[33]='29';p_n[33]='Málaga';
 p_c[34]='52';p_n[34]='Melilla';
 p_c[35]='30';p_n[35]='Murcia';
 p_c[36]='31';p_n[36]='Navarra';
 p_c[37]='32';p_n[37]='Orense';
 p_c[38]='34';p_n[38]='Palencia';
 p_c[39]='36';p_n[39]='Pontevedra';
 p_c[40]='37';p_n[40]='Salamanca';
 p_c[41]='38';p_n[41]='Santa Cruz de Tenerife';
 p_c[42]='40';p_n[42]='Segovia';
 p_c[43]='41';p_n[43]='Sevilla';
 p_c[44]='42';p_n[44]='Soria';
 p_c[45]='43';p_n[45]='Tarragona';
 p_c[46]='44';p_n[46]='Teruel';
 p_c[47]='45';p_n[47]='Toledo';
 p_c[48]='46';p_n[48]='Valencia';
 p_c[49]='47';p_n[49]='Valladolid';
 p_c[50]='48';p_n[50]='Vizcaya';
 p_c[51]='49';p_n[51]='Zamora';
 p_c[52]='50';p_n[52]='Zaragoza';

/*array de idiomas*/
var i_c=new Array();
var i_n=new Array();
 i_c[0]='*NuLo*'; i_n[0]='--Elegir';
 i_c[1]='aa';i_n[1]='afar';
 i_c[2]='ab';i_n[2]='abjaso (o abjasiano)';
 i_c[3]='af';i_n[3]='afrikaans';
 i_c[4]='am';i_n[4]='amarico';
 i_c[5]='an';i_n[5]='aragones';
 i_c[6]='ar';i_n[6]='arabe';
 i_c[7]='as';i_n[7]='assames';
 i_c[8]='ay';i_n[8]='aymara';
 i_c[9]='az';i_n[9]='azeri';
 i_c[10]='ba';i_n[10]='baskir';
 i_c[11]='be';i_n[11]='bielorruso';
 i_c[12]='bg';i_n[12]='bulgaro';
 i_c[13]='bh';i_n[13]='bihari';
 i_c[14]='bi';i_n[14]='bislama';
 i_c[15]='bn';i_n[15]='bengali';
 i_c[16]='bo';i_n[16]='tibetano';
 i_c[17]='br';i_n[17]='breton';
 i_c[18]='ca';i_n[18]='catalan';
 i_c[19]='ce';i_n[19]='checheno';
 i_c[20]='co';i_n[20]='corso';
 i_c[21]='cs';i_n[21]='checo';
 i_c[22]='cy';i_n[22]='gales';
 i_c[23]='da';i_n[23]='danes';
 i_c[24]='de';i_n[24]='aleman';
 i_c[25]='dz';i_n[25]='dzongkha';
 i_c[26]='el';i_n[26]='griego';
 i_c[27]='en';i_n[27]='ingles';
 i_c[28]='eo';i_n[28]='esperanto';
 i_c[29]='es';i_n[29]='español (o castellano)';
 i_c[30]='et';i_n[30]='estonio';
 i_c[31]='eu';i_n[31]='euskera (vasco)';
 i_c[32]='fa';i_n[32]='farsi (o persa)';
 i_c[33]='fi';i_n[33]='fines (o finlandes)';
 i_c[34]='fj';i_n[34]='fijiano fidji';
 i_c[35]='fo';i_n[35]='feroes';
 i_c[36]='fr';i_n[36]='frances';
 i_c[37]='fy';i_n[37]='frison (o frisio)';
 i_c[38]='ga';i_n[38]='irlandes (o gaelico)';
 i_c[39]='gd';i_n[39]='gaelico escoces';
 i_c[40]='gl';i_n[40]='gallego';
 i_c[41]='gn';i_n[41]='guarani';
 i_c[42]='gu';i_n[42]='guyarati (o gujarati)';
 i_c[43]='gv';i_n[43]='manes' ;
 i_c[44]='ha';i_n[44]='hausa';
 i_c[45]='he';i_n[45]='hebreo';
 i_c[46]='hi';i_n[46]='hindi (o hindu)';
 i_c[47]='hr';i_n[47]='croata';
 i_c[48]='hu';i_n[48]='hungaro';
 i_c[49]='hy';i_n[49]='armenio';
 i_c[50]='ia';i_n[50]='interlingua';
 i_c[51]='id';i_n[51]='indonesio';
 i_c[52]='ie';i_n[52]='interlingue';
 i_c[53]='ik';i_n[53]='inupiak';
 i_c[54]='is';i_n[54]='islandes';
 i_c[55]='it';i_n[55]='italiano';
 i_c[56]='iu';i_n[56]='inuktitut';
 i_c[57]='ja';i_n[57]='japones';
 i_c[58]='jv';i_n[58]='javanes';
 i_c[59]='ka';i_n[59]='georgiano';
 i_c[60]='kk';i_n[60]='kazajo (o kazajio)';
 i_c[61]='kl';i_n[61]='kalaallisut(groenlandes)';
 i_c[62]='km';i_n[62]='camboyano(jemer)';
 i_c[63]='kn';i_n[63]='kannada';
 i_c[64]='ko';i_n[64]='coreano';
 i_c[65]='ks';i_n[65]='cachemir';
 i_c[66]='ku';i_n[66]='kurdo';
 i_c[67]='kw';i_n[67]='cornico';
 i_c[68]='ky';i_n[68]='kirguis';
 i_c[69]='la';i_n[69]='latin';
 i_c[70]='lb';i_n[70]='luxemburgues';
 i_c[71]='ln';i_n[71]='lingala';
 i_c[72]='lo';i_n[72]='laosiano';
 i_c[73]='lt';i_n[73]='lituano';
 i_c[74]='lv';i_n[74]='leton';
 i_c[75]='mg';i_n[75]='malgache (o malgasy)';
 i_c[76]='mi';i_n[76]='maori';
 i_c[77]='mk';i_n[77]='macedonio';
 i_c[78]='ml';i_n[78]='malayalam';
 i_c[79]='mn';i_n[79]='mongol';
 i_c[80]='mo';i_n[80]='moldavo';
 i_c[81]='mr';i_n[81]='marata';
 i_c[82]='ms';i_n[82]='malayo';
 i_c[83]='mt';i_n[83]='maltes';
 i_c[84]='my';i_n[84]='birmano';
 i_c[85]='na';i_n[85]='nauruano';
 i_c[86]='ne';i_n[86]='nepali';
 i_c[87]='nl';i_n[87]='neerlandes (u holandes)';
 i_c[88]='no';i_n[88]='noruego';
 i_c[89]='oc';i_n[89]='occitano';
 i_c[90]='om';i_n[90]='oromo';
 i_c[91]='or';i_n[91]='oriya';
 i_c[92]='pa';i_n[92]='panyabi (o penyabi)';
 i_c[93]='pl';i_n[93]='polaco';
 i_c[94]='ps';i_n[94]='pashtu (o pashto)';
 i_c[95]='pt';i_n[95]='portugues';
 i_c[96]='qu';i_n[96]='quechua';
 i_c[97]='rm';i_n[97]='retorromanico';
 i_c[98]='rn';i_n[98]='rundi';
 i_c[99]='ro';i_n[99]='rumano';
 i_c[100]='ru';i_n[100]='ruso';
 i_c[101]='rw';i_n[101]='ruandes';
 i_c[102]='sa';i_n[102]='sanscrito';
 i_c[103]='sd';i_n[103]='shindi';
 i_c[104]='sg';i_n[104]='sango';
 i_c[105]='sh';i_n[105]='serbocroata';
 i_c[106]='si';i_n[106]='cinagles';
 i_c[107]='sk';i_n[107]='eslovaco';
 i_c[108]='sl';i_n[108]='esloveno';
 i_c[109]='sm';i_n[109]='samoano';
 i_c[110]='sn';i_n[110]='shona';
 i_c[111]='so';i_n[111]='somali';
 i_c[112]='sq';i_n[112]='albanes';
 i_c[113]='sr';i_n[113]='serbio';
 i_c[114]='ss';i_n[114]='swazi';
 i_c[115]='st';i_n[115]='seshoto';
 i_c[116]='su';i_n[116]='sudanes';
 i_c[117]='sv';i_n[117]='sueco';
 i_c[118]='sw';i_n[118]='suajili';
 i_c[119]='ta';i_n[119]='tamil';
 i_c[120]='te';i_n[120]='telugu';
 i_c[121]='tg';i_n[121]='tayiko';
 i_c[122]='th';i_n[122]='tailandes';
 i_c[123]='ti';i_n[123]='tigriña';
 i_c[124]='tk';i_n[124]='turcomano';
 i_c[125]='tl';i_n[125]='tagalo';
 i_c[126]='tn';i_n[126]='tswana';
 i_c[127]='to';i_n[127]='tongano';
 i_c[128]='tr';i_n[128]='turco';
 i_c[129]='ts';i_n[129]='tsonga';
 i_c[130]='tt';i_n[130]='tartaro';
 i_c[131]='tw';i_n[131]='twi';
 i_c[132]='uk';i_n[132]='ucraniano';
 i_c[133]='ur';i_n[133]='urdu';
 i_c[134]='uz';i_n[134]='uzbeko';
 i_c[135]='vi';i_n[135]='vietnamita';
 i_c[136]='vo';i_n[136]='volapuk';
 i_c[137]='wo';i_n[137]='wolof';
 i_c[138]='xh';i_n[138]='xhosa';
 i_c[139]='yi';i_n[139]='yidish';
 i_c[140]='yo';i_n[140]='yoruba';
 i_c[141]='zh';i_n[141]='chino';
 i_c[142]='zu';i_n[142]='zulu';

/* array de paises*/
var p= new Array();
var c= new Array();
c[0]='*NuLo*'; p[0]='--Elegir';
c[1]='afg';p[1]='Afganistán';
c[2]='alb';p[2]='Albania';
c[3]='deu';p[3]='Alemania';
c[4]='dza';p[4]='Algeria';
c[5]='and';p[5]='Andorra';
c[6]='ago';p[6]='Angola';
c[7]='aia';p[7]='Anguilla';
c[8]='atg';p[8]='Antigua';
c[9]='ant';p[9]='Antillas Holandesas';
c[10]='sau';p[10]='Arabia Saudí';
c[11]='n203';p[11]='Argelia';
c[12]='arg';p[12]='Argentina';
c[13]='arm';p[13]='Armenia';
c[14]='aus';p[14]='Australia';
c[15]='aut';p[15]='Austria';
c[16]='aze';p[16]='Azerbaiyán';
c[17]='bhs';p[17]='Bahamas';
c[18]='bhr';p[18]='Bahrein';
c[19]='bgd';p[19]='Bangladesh';
c[20]='brb';p[20]='Barbados';
c[21]='blr';p[21]='Belarús (Bielorrusia)';
c[22]='bel';p[22]='Bélgica';
c[23]='blz';p[23]='Belice';
c[24]='ben';p[24]='Benin';
c[25]='bmu';p[25]='Bermudas';
c[26]='btn';p[26]='Bhutan';
c[27]='bol';p[27]='Bolivia';
c[28]='bih';p[28]='Bosnia-Herzegovina';
c[29]='bwa';p[29]='Bostwana';
c[30]='bra1';p[30]='Brasil';
c[31]='brn';p[31]='Brunei';
c[32]='bgr';p[32]='Bulgaria';
c[33]='bfa';p[33]='Burkina Faso';
c[34]='bdi';p[34]='Burundi';
c[35]='cpv';p[35]='Cabo Verde';
c[36]='cym';p[36]='Caimán, Islas';
c[37]='khm';p[37]='Camboya';
c[38]='cmr';p[38]='Camerún';
c[39]='can';p[39]='Canadá';
c[40]='tcd';p[40]='Chad';
c[41]='n159';p[41]='Chekia';
c[42]='chl';p[42]='Chile';
c[43]='chn';p[43]='China';
c[44]='cyp';p[44]='Chipre';
c[45]='col';p[45]='Colombia';
c[46]='n209';p[46]='Comores';
c[47]='com';p[47]='Comoro';
c[48]='cog';p[48]='Congo';
c[49]='cok';p[49]='Cook, Islas';
c[50]='civ';p[50]='Costa de Marfil';
c[51]='cri';p[51]='Costa Rica';
c[52]='hrv';p[52]='Croacia';
c[53]='cub';p[53]='Cuba';
c[54]='n158';p[54]='Daquestan';
c[55]='dnk';p[55]='Dinamarca';
c[56]='dji';p[56]='Djibuti';
c[57]='dma';p[57]='Dominica';
c[58]='ecu';p[58]='Ecuador';
c[59]='egy';p[59]='Egipto';
c[60]='slv';p[60]='El Salvador';
c[61]='are';p[61]='Emiratos Árabes Unidos';
c[62]='eri';p[62]='Eritrea';
c[63]='svk';p[63]='Eslovaquia';
c[64]='svn';p[64]='Eslovenia';
c[65]='esp';p[65]='España';
c[66]='usa';p[66]='Estados Unidos';
c[67]='est';p[67]='Estonia';
c[68]='eth';p[68]='Etiopía';
c[69]='fro';p[69]='Faeroes, Islas';
c[70]='fji';p[70]='Fidji';
c[71]='phl';p[71]='Filipinas';
c[72]='fin';p[72]='Finlandia';
c[73]='fra';p[73]='Francia';
c[74]='gab';p[74]='Gabón';
c[75]='gmb';p[75]='Gambia';
c[76]='geo';p[76]='Georgia';
c[77]='gha';p[77]='Ghana';
c[78]='gib';p[78]='Gibraltar';
c[79]='grd';p[79]='Granada';
c[80]='grc';p[80]='Grecia';
c[81]='grl';p[81]='Groenlandia';
c[82]='glp';p[82]='Guadalupe';
c[83]='gum';p[83]='Guam';
c[84]='gtm';p[84]='Guatemala';
c[85]='guf';p[85]='Guayana Francesa';
c[86]='gin';p[86]='Guinea';
c[87]='gnq';p[87]='Guinea Ecuatorial';
c[88]='gnb';p[88]='Guinea-Bissau';
c[89]='guy';p[89]='Guyana';
c[90]='hti';p[90]='Haití';
c[91]='nld';p[91]='Holanda';
c[92]='hnd';p[92]='Honduras';
c[93]='hkg';p[93]='Hong Kong';
c[94]='hun';p[94]='Hungría';
c[95]='ind';p[95]='India';
c[96]='idn';p[96]='Indonesia';
c[97]='irq';p[97]='Irak';
c[98]='irn';p[98]='Irán';
c[99]='irl';p[99]='Irlanda';
c[100]='isl';p[100]='Islandia';
c[101]='isr';p[101]='Israel';
c[102]='ita';p[102]='Italia';
c[103]='jam';p[103]='Jamaica';
c[104]='jpn';p[104]='Japón';
c[105]='jor';p[105]='Jordania';
c[106]='kaz';p[106]='Kazajstan';
c[107]='ken';p[107]='Kenia';
c[108]='kgz';p[108]='Kirguistán';
c[109]='kir';p[109]='Kiribati';
c[110]='n160';p[110]='Kosovo';
c[111]='n1';p[111]='Kurdistan';
c[112]='kwt';p[112]='Kuwait';
c[113]='lso';p[113]='Lesotho';
c[114]='lva';p[114]='Letonia';
c[115]='lbn';p[115]='Líbano';
c[116]='lbr';p[116]='Liberia';
c[117]='n224';p[117]='Libia';
c[118]='lie';p[118]='Liechtenstein';
c[119]='ltu';p[119]='Lituania';
c[120]='lux';p[120]='Luxemburgo';
c[121]='mac';p[121]='Macao';
c[122]='mkd';p[122]='Macedonia, Antigua Rep.Yugosla';
c[123]='mdg';p[123]='Madagascar';
c[124]='mys';p[124]='Malasia';
c[125]='mwi';p[125]='Malawi';
c[126]='mdv';p[126]='Maldivas, Islas';
c[127]='mli';p[127]='Mali';
c[128]='mlt';p[128]='Malta';
c[129]='flk';p[129]='Malvinas, Islas (Falklands)';
c[130]='mnp';p[130]='Marianas del Norte, Islas';
c[131]='mar';p[131]='Marruecos';
c[132]='mhl';p[132]='Marshall, Islas';
c[133]='mtq';p[133]='Martinica';
c[134]='mus';p[134]='Mauricio';
c[135]='mrt';p[135]='Mauritania';
c[136]='mex';p[136]='Méjico';
c[137]='fsm';p[137]='Micronesia';
c[138]='mco';p[138]='Mónaco';
c[139]='mng';p[139]='Mongolia';
c[140]='msr';p[140]='Montserrat';
c[141]='moz';p[141]='Mozambique';
c[142]='mmr';p[142]='Myanmar (Birmania)';
c[143]='nam';p[143]='Namibia';
c[144]='nru';p[144]='Nauru';
c[145]='npl';p[145]='Nepal';
c[146]='n244';p[146]='Ngwane';
c[147]='nic';p[147]='Nicaragua';
c[148]='ner';p[148]='Níger';
c[149]='nga';p[149]='Nigeria';
c[150]='niu';p[150]='Niue';
c[151]='nfk';p[151]='Norfolk, Isla de';
c[152]='nor';p[152]='Noruega';
c[153]='ncl';p[153]='Nueva Caledonia';
c[154]='png';p[154]='Nueva Guinea Papúa';
c[155]='nzl';p[155]='Nueva Zelanda';
c[156]='omn';p[156]='Omán';
c[157]='n121';p[157]='Paises Bajos';
c[158]='pak';p[158]='Pakistán';
c[159]='plw';p[159]='Palau';
c[160]='pse';p[160]='Palestina, Territorios Ocupado';
c[161]='pan';p[161]='Panamá';
c[162]='pry';p[162]='Paraguay';
c[163]='per';p[163]='Perú';
c[164]='pcn';p[164]='Pitcairn, Isla';
c[165]='pyf';p[165]='Polinesia Francesa';
c[166]='pol';p[166]='Polonia';
c[167]='prt';p[167]='Portugal';
c[168]='pri';p[168]='Puerto Rico';
c[169]='qat';p[169]='Qatar';
c[170]='gbr';p[170]='Reino Unido';
c[171]='caf';p[171]='República Centroafricana';
c[172]='cze';p[172]='República Checa';
c[173]='kor';p[173]='República de Corea';
c[174]='mda';p[174]='República de Moldavia';
c[175]='prk';p[175]='República Democrática de Cor';
c[176]='lao';p[176]='República Democrática de Lao';
c[177]='cod';p[177]='República Democrática del Co';
c[178]='dom';p[178]='República Dominicana';
c[179]='reu';p[179]='Reunión';
c[180]='rwa';p[180]='Ruanda';
c[181]='rou';p[181]='Rumanía';
c[182]='rus';p[182]='Rusia, Federación';
c[183]='esh';p[183]='Sahara Occidental';
c[184]='kna';p[184]='Saint Kitts y Nevis';
c[185]='slb';p[185]='Salomón, Islas';
c[186]='wsm';p[186]='Samoa';
c[187]='asm';p[187]='Samoa Americana';
c[188]='smr';p[188]='San Marino';
c[189]='vct';p[189]='San Vicente y Las Granadinas';
c[190]='shn';p[190]='Santa Elena';
c[191]='lca';p[191]='Santa Lucía';
c[192]='stp';p[192]='Santo Tomé y Príncipe';
c[193]='sen';p[193]='Senegal';
c[194]='n134';p[194]='Servia y Montenegro';
c[195]='syc';p[195]='Seychelles';
c[196]='sle';p[196]='Sierra Leona';
c[197]='sgp';p[197]='Singapur';
c[198]='syr';p[198]='Siria';
c[199]='som';p[199]='Somalia';
c[200]='lka';p[200]='Sri Lanka';
c[201]='spm';p[201]='St-Pierre y Miquelon';
c[202]='zaf';p[202]='Sudáfrica';
c[203]='sdn';p[203]='Sudán';
c[204]='swe';p[204]='Suecia';
c[205]='che';p[205]='Suiza';
c[206]='sur';p[206]='Surinám';
c[207]='sjm';p[207]='Svalbard y Jan Mayen, Islas';
c[208]='swz';p[208]='Swazilandia';
c[209]='tha';p[209]='Tailandia';
c[210]='twn';p[210]='Taiwan';
c[211]='tza';p[211]='Tanzania';
c[212]='tjk';p[212]='Tayikistán';
c[213]='tls';p[213]='Timor';
c[214]='tgo';p[214]='Togo';
c[215]='tkl';p[215]='Tokelau';
c[216]='ton';p[216]='Tonga';
c[217]='tto';p[217]='Trinidad y Tobago';
c[218]='tun';p[218]='Túnez';
c[219]='tkm';p[219]='Turkmenistán';
c[220]='tca';p[220]='Turks y Caicos, Islas';
c[221]='tur';p[221]='Turquía';
c[222]='tuv';p[222]='Tuvalu';
c[223]='ukr';p[223]='Ucrania';
c[224]='uga';p[224]='Uganda';
c[225]='ury';p[225]='Uruguay';
c[226]='uzb';p[226]='Uzbekistán';
c[227]='vut';p[227]='Vanuatu';
c[228]='vat';p[228]='Vaticano';
c[229]='ven';p[229]='Venezuela';
c[230]='vnm';p[230]='Viet Nam';
c[231]='vir';p[231]='Vírgenes, Islas (Estados Unid';
c[232]='vgb';p[232]='Vírgenes, Islas (Reino Unido)';
c[233]='wlf';p[233]='Wallis y Fortuna, Islas';
c[234]='yem';p[234]='Yemen';
c[235]='yug';p[235]='Yugoslavia';
c[236]='zmb';p[236]='Zambia';
c[237]='n252';p[237]='Zimbabwe';
c[238]='n2_1';p[238]='Aruba';
c[239]='n2_2';p[239]='Guernsey';
c[240]='n2_3';p[240]='Isla de Man';
c[241]='n2_4';p[241]='Islas Aland';
c[242]='n2_5';p[242]='Islas Channel';
c[243]='n2_6';p[243]='Islas Solomon';
c[244]='n2_7';p[244]='Islas Vírgenes Británicas';
c[245]='n2_8';p[245]='Kyrgyzstan';
c[246]='n2_9';p[246]='Maore (Mayotte)';
c[247]='n2_10';p[247]='Moldova';

function paises(elegido,nombre,edicion){ //Pais elegido, nombre para el control, edicion (true/false)
	retornar="";
	if (edicion){
		document.write("<select class=field name='"+nombre+"' >");
		for(x=0;x<248;x++){
		document.write("<option value='"+c[x]+"'");
		if(elegido==c[x]) document.write(" selected ") ;
		document.write(" >"+p[x]+"</option>");
		}
		document.write ("</select>");
		}
	else { //Simplemente escribimos el nombre selected
		for(x=0;x<248;x++){
			if(elegido==c[x]) {document.write(p[x]);return(p[x]);}
			}
		}
	return retornar; //Retornamos el nombre elegido
	}


function idiomas(elegido,nombre,edicion){ //idioma elegido, nombre para el control, edicion (true/false)
	retornar="";
	if (edicion){
		document.write("<select class=field name='"+nombre+"' >");
		for(x=0;x<143;x++){
		document.write("<option value='"+i_c[x]+"'");
		if(elegido==i_c[x]) document.write(" selected ") ;
		document.write(" >"+i_n[x].substr(0,20)+"</option>");
		}
		document.write ("</select>");
		}
	else { //Simplemente escribimos el nombre selected
		for(x=0;x<248;x++){
			if(elegido==i_c[x]) {document.write(i_n[x]);return(i_n[x]);}
			}
		}
	return retornar; //Retornamos el nombre elegido
	}

function provincias(elegido,nombre,edicion){ //idioma elegido, nombre para el control, edicion (true/false)
	retornar="";
	if (edicion){
		document.write("<select class=field name='"+nombre+"' >");
		for(x=0;x<53;x++){
		document.write("<option value='"+p_c[x]+"'");
		if(elegido==p_c[x]) document.write(" selected ") ;
		document.write(" >"+p_n[x]+"</option>");
		}
		document.write ("</select>");
		}
	else { //Simplemente escribimos el nombre selected
		for(x=0;x<248;x++){
			if(elegido==p_c[x]) {document.write(p_n[x]);return(p_n[x]);}
			}
		}
	return retornar; //Retornamos el nombre elegido
	}


function f(solapas,activar){
        for (x=0;x < solapas.length;x++){
                if(activar==solapas[x]){ 
			if (document.getElementById("div_"+solapas[x]))
                        	document.getElementById("div_"+solapas[x]).style.visibility="visible";
                        if (document.getElementById("option_"+solapas[x]))
                        	document.getElementById("option_"+solapas[x]).className="opselec";
                        	//document.getElementById("option_"+solapas[x]).style.background="LemonChiffon";
                        }
                else{
			if (document.getElementById("div_"+solapas[x]))
                        	document.getElementById("div_"+solapas[x]).style.visibility="hidden";
                        if (document.getElementById("option_"+solapas[x])){
					document.getElementById("option_"+solapas[x]).style.borderColor="transparent";
					//document.getElementById("option_"+solapas[x]).style.background="LightGreen";
					document.getElementById("option_"+solapas[x]).className="option";
					}
                        }
                }
        }


/* Limitar el texto en un TEXTAREA */

function ismaxlength(obj){
var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
if (obj.getAttribute && obj.value.length>mlength)
obj.value=obj.value.substring(0,mlength)
}

function isValidDate(dateStr) {
// Checks for the following valid date formats:
// // MM/DD/YY   MM/DD/YYYY   MM-DD-YY   MM-DD-YYYY
// // Also separates date into month, day, and year variables
//
// var datePat = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{2}|\d{4})$/;
//
// // To require a 4 digit year entry, use this line instead:
var datePat = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{4})$/;
//
var matchArray = dateStr.match(datePat); // is the format ok?
if (matchArray == null) {
	alert("El formato de la fecha debe ser DD/MM/AAAA ")
	return false;
	}
//month = matchArray[1]; // parse date into variables
//day = matchArray[3];
//Lo cambio porque necesito DD/MM/YYYY
day = matchArray[1]; // parse date into variables
month = matchArray[3];
year = matchArray[4];
if (month < 1 || month > 12) { // check month range
	alert("El mes debe estar entre 1 y 12");
	return false;
	}
if (day < 1 || day > 31) {
alert("El día debe estar entre 1 y 31");
return false;
}
if ((month==4 || month==6 || month==9 || month==11) && day==31) {
	alert("Mes "+month+" no tiene 31 días")
	return false
	}

if (month == 2) { // check for february 29th
	var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
	if (day>29 || (day==29 && !isleap)) {
	alert("Febrero " + year + " no tiene " + day + " días!");
	return false;
    	}
    }
return true;  // date is valid
}

function ocultar_mostrar(idcheck,idbloque){
                        if (document.getElementById(idcheck).checked )
                                document.getElementById(idbloque).style.display='block';       
                        else
                                document.getElementById(idbloque).style.display='none';        
                        }

function ocultar(idbloque){
                        if (this.checked )
                                document.getElementById(idbloque).style.display='block';       
                        else{
				alert("Muestro")
                                document.getElementById(idbloque).style.display='none';        
				}
                        }

function form_is_modified(oForm)
{
	var el, opt, hasDefault, i = 0, j;
	while (el = oForm.elements[i++]) {
		switch (el.type) {
			case 'text' :
                   	case 'textarea' :
                   	case 'hidden' :
                         	if (!/^\s*$/.test(el.value) && el.value != el.defaultValue) return true;
                         	break;
                   	case 'checkbox' :
                   	case 'radio' :
                         	if (el.checked != el.defaultChecked) return true;
                         	break;
                   	case 'select-one' :
                   	case 'select-multiple' :
                         	j = 0, hasDefault = false;
                         	while (opt = el.options[j++])
                                	if (opt.defaultSelected) hasDefault = true;
                         	j = hasDefault ? 0 : 1;
                         	while (opt = el.options[j++]) 
                                	if (opt.selected != opt.defaultSelected) return true;
                         	break;
		}
	}
	return false;
}
/*
Funcion al envento OnBeforeUpdate de las paginas con formularios.
El on submit del formulario debe poner check a false para que el propio submit 
no se detecte como un abandono de página
<form onSubmit='check=false'>
en el documento se pone <script> check=true <script> <body onBeforeUload=alerta_salvar(documents.forms.nombre)>
*/

function alerta_salvar(f){
        if (form_is_modified(f) & check ) return 'Hay datos sin salvar';
        }

/* 
Esta funcion se pone en el onsubmit del form. Si no hay cambios no se sube
 Si hay cambios sube y pone check a false para que el onBeforeUpload de la página no salte
*/
function check_submit(f){
        if (form_is_modified(f)) {
			check=false;
			return true;
			}
	//else return false;
	else return true;
	}
