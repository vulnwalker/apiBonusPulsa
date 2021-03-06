var rkbmdPemeliharaan_v2Skpd = new SkpdCls({
	prefix : 'rkbmdPemeliharaan_v2Skpd', 
	formName: 'rkbmdPemeliharaan_v2Form',
	pilihBidangAfter : function(){rkbmdPemeliharaan_v2.refreshList(true);},
	pilihUnitAfter : function(){rkbmdPemeliharaan_v2.refreshList(true);},
	pilihSubUnitAfter : function(){rkbmdPemeliharaan_v2.refreshList(true);},
	pilihSeksiAfter : function(){rkbmdPemeliharaan_v2.refreshList(true);}
});

var rkbmdPemeliharaan_v2 = new DaftarObj2({
	prefix : 'rkbmdPemeliharaan_v2',
	url : 'pages.php?Pg=rkbmdPemeliharaan_v2', 
	formName : 'rkbmdPemeliharaan_v2Form',
	
	loading:function(){
		this.topBarRender();
		this.filterRender();
		this.daftarRender();
		//this.sumHalRender();
		
	},
		
	daftarRender:function(){
		var jenisKegiatan = document.getElementById('cmbJenisrkbmdPemeliharaan_v2');
		/*cmbJenisrkbmdPemeliharaan_v2.remove(0);*/
		var me =this; //render daftar 
		addCoverPage2(
			'daftar_cover',	1, 	true, true,	{renderTo: this.prefix+'_cont_daftar',
			imgsrc: 'images/wait.gif',
			style: {position:'absolute', top:'5', left:'5'}
			}
		);
		$.ajax({
		  	url: this.url+'&tipe=daftar',
		 	type:'POST', 
			data:$('#'+this.formName).serialize(), 
		  	success: function(data) {		
				var resp = eval('(' + data + ')');
				document.getElementById(me.prefix+'_cont_daftar').innerHTML = resp.content;
				//me.sumHalRender();
		  	}
		});
		
	},
	
	Info: function(){	
		var me = this;
	    var cover = this.prefix+'_formcover';
			$.ajax({
				type:'POST', 
			  	url: this.url+'&tipe=Info',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.body.style.overflow='hidden';
						addCoverPage2(cover,999,true,false);	
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);			
					}
				 }
			});
	},
	Cari: function(){
		popupBarang.kodeBarang = 'kodeBarang';
		popupBarang.namaBarang = 'namaBarang'; 
		popupBarang.satuanBarang = 'satuan'; 
		popupBarang.windowShow();
		
	},			
	Edit:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			

			var aForm = document.getElementById(this.formName);
			$.ajax({
			  url: this.url+'&tipe=editTab',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == "") {
						var IDrenja = Number(resp.content.idrenja);
						aForm.action= 'pages.php?Pg=rkbmd_'+resp.content.kemana+'&YN=1&id='+IDrenja;
						aForm.target='_blank';
						aForm.submit();	
						aForm.target='';
					}else{
						alert(resp.err);		
					}	

			  }
			});
		}else{
			alert(errmsg);
		}
		
	},	
	remove:function(){
		var me = this;
		errmsg = this.CekCheckbox();
		if(errmsg ==''){ 
			var box = this.GetCbxChecked();
			
			$.ajax({
			  url: this.url+'&tipe=remove',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');
					rkbmdPemeliharaan_v2.refreshList(true);
					
			  }
			});
		}else{
			alert(errmsg);
		}
		
	},Validasi:function(id_anggaran){
		var me = this;
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			if(me.satuan_form==0){//baru dari satuan
				addCoverPage2(cover,1,true,false);	
			}else{//baru dari barang
				addCoverPage2(cover,999,true,false);	
			}
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=Validasi&id_anggaran='+id_anggaran,
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						delElem(cover);
						alert(resp.err);
						if(resp.err == 'Tahap Penyusunan Telah Habis'){
							window.location.reload();
						}
					}			
			
			  	}
			});

		
	},
	SaveValid: function(){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:$('#'+this.prefix+'_form').serialize(),
			url: this.url+'&tipe=SaveValid',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					me.Close();
						/*me.AfterSimpan();	*/
						rkbmdPemeliharaan_v2.refreshList(true);
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,		
	AfterSimpan : function(){
		if(document.getElementById('Kunjungan_cont_daftar')){
		this.refreshList(true);}
	}, 
	InputBaru: function(){
		var me = this;
			
		errmsg = '';
		
		if($("#rkbmdPemeliharaan_v2SkpdfmUrusan").val() == '00'){
			errmsg = "Pilih Urusan";
		}else if($("#rkbmdPemeliharaan_v2SkpdfmSKPD").val() == '00'){
			errmsg = "Pilih Bidang";
		}else if($("#rkbmdPemeliharaan_v2SkpdfmUNIT").val() == '00'){
			errmsg = "Pilih SKPD";
		}else if($("#rkbmdPemeliharaan_v2SkpdfmSUBUNIT").val() == '00'){
			errmsg = "Pilih UNIT";
		}else if($("#rkbmdPemeliharaan_v2SkpdfmSEKSI").val() == '000'){
			errmsg = "Pilih SUB UNIT";
		}else if($("#cmbJenisrkbmdPemeliharaan_v2").val() == ''){
			errmsg = "Pilih JENIS rkbmdPemeliharaan_v2";
		}
		
		
		if(errmsg ==''){
		
			var me = this;
			var aForm = document.getElementById(this.formName);
			$.ajax({
			  url: this.url+'&tipe=newTab',
			  type : 'POST',
			  data:$('#'+this.formName).serialize(),
			  success: function(data) {
					var resp = eval('(' + data + ')');
					if(resp.err == "") {
						var IDrenja = Number(resp.content.idrenja);
						aForm.action= 'pages.php?Pg=rkbmd_'+resp.content.kemana+'&YN=1&id='+IDrenja;
						aForm.target='_blank';
						aForm.submit();	
						aForm.target='';
					}else{
						alert(resp.err);		
					}	

			  }
			});
			
			
		}else{
				alert(errmsg);
		}	
	},
	koreksi:function(id){
		/*$("#alignKoreksi").attr('align','center');*/
		$("#updatePengguna"+id).attr('align','center');
		$("#spanJumlah"+id).html("<input type='text' name='jumlah"+id+"' id='jumlah"+id+"' onkeypress='return event.charCode >= 48 && event.charCode <= 57' onkeyup=rkbmdPemeliharaan_v2.bantu('Jumlah"+id+"'); style='text-align: right; width:40px;'>  ");
			$.ajax({
				type:'POST',
				data :{id : id},
				url: this.url+'&tipe=comboBoxPemenuhan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.err != ''){
						alert(resp.err);
					}else{
					// $("#spanCaraPemenuhan"+id).html(resp.content.caraPemenuhan  + resp.content.tambahCaraPemenuhan);
					}
					
				 }
			  });
		$("#save"+id).html("<img src='datepicker/save.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkbmdPemeliharaan_v2.submitKoreksi('"+id+"');></img> &nbsp  &nbsp <img src='images/administrator/images/invalid.png' width='20px' heigh='20px' style='cursor : pointer;' onclick=rkbmdPemeliharaan_v2.cancelKoreksi('"+id+"');></img> ");
	},
	sesuai:function(id){
		var isi = $("#volumeBarang"+id+"").val();
		$("#updatePengguna"+id).attr('align','center');
		

		    $.ajax({
					type:'POST', 
					data:{idAwal : id,
						  angkaKoreksi : isi,
						  jenisrkbmdPemeliharaan_v2  : $("#cmbJenisrkbmdPemeliharaan_v2").val()	
						  },
					url: this.url+'&tipe=koreksi',
				  	success: function(data) {		
						var resp = eval('(' + data + ')');	
						if(resp.err != ''){
							alert(resp.err);
							if(resp.err == 'Tahap Koreksi Telah Habis'){
								window.location.reload();
							}
						}else{
							rkbmdPemeliharaan_v2.refreshList(true);
						}
						
					 }
				  });
	},
	submitKoreksi:function(id) {
	var angkaKoreksi = $("#jumlah"+id).val();
	if(angkaKoreksi <= '0'){
		alert("angka Salah");
	}else{
	    $.ajax({
				type:'POST', 
				data:{idAwal : id,
					  angkaKoreksi : angkaKoreksi,
					  jenisrkbmdPemeliharaan_v2  : $("#cmbJenisrkbmdPemeliharaan_v2").val()	
					  },
				url: this.url+'&tipe=koreksi',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');	
					if(resp.err != ''){
						alert(resp.err);
						if(resp.err == 'Tahap Koreksi Telah Habis'){
								window.location.reload();
							}
					}else{
						rkbmdPemeliharaan_v2.refreshList(true);
					}
					
				 }
			  });
		}
	    
	},
	catatan:function(id){
		var me = this;

			
			 var cover = this.prefix+'_formcover';

			$.ajax({
				type:'POST', 
				data:{idAwal : id },
			  	url: this.url+'&tipe=Catatan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
					   
						document.body.style.overflow='hidden';
						addCoverPage2(cover,999,true,false);	
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
					}			
					
					
			  	}
			});

		
	},
	
	formPemenuhan:function(id){
		var me = this;

			
			 var cover = this.prefix+'_formcover';

			$.ajax({
				type:'POST', 
				data : {id : id},
			  	url: this.url+'&tipe=formPemenuhan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
					   
						document.body.style.overflow='hidden';
						addCoverPage2(cover,999,true,false);	
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						alert(resp.err);
					}			
					
					
			  	}
			});

		
	},
	
	SaveCatatan: function(id){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:{id : id,
				  catatan : $("#catatan").val()},
			url: this.url+'&tipe=SaveCatatan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
						me.Close();
						me.AfterSimpan();						
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	
	SaveCaraPemenuhan: function(id){
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		$.ajax({
			type:'POST', 
			data:{caraPemenuhan : $("#caraPemenuhan").val()},
			url: this.url+'&tipe=SaveCaraPemenuhan',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
						var myOptions = {
						    val1 : $("#caraPemenuhan").val()
						};
						$.each(myOptions, function(val, text) {
						    $('#pemenuhan'+id).append( new Option(text,val) );
						});
						me.Close();
						me.AfterSimpan();	
									
				}else{
					alert(resp.err);
				}
		  	}
		});
	},
	formatCurrency:function(num) {
		num = num.toString().replace(/\$|\,/g,'');
		if(isNaN(num))
		num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num*100+0.50000000001);
		cents = num%100;
		num = Math.floor(num/100).toString();
		if(cents<10)
		cents = "0" + cents;
		for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+'.'+
		num.substring(num.length-(4*i+3));
		return (((sign)?'':'-') + '' + num );
	},
	bantu : function(id){
		var idAngka = id.replace('J','j');
		var angka = $("#"+idAngka).val();
		$("#bantu"+id).text(rkbmdPemeliharaan_v2.formatCurrency(angka));
	},Laporan:function(){
		var me = this;			
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			if(me.satuan_form==0){//baru dari satuan
				addCoverPage2(cover,1,true,false);	
			}else{//baru dari barang
				addCoverPage2(cover,999,true,false);	
			}
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=Laporan',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						delElem(cover);
						alert(resp.err);
					}			
			
			  	}
			});
		
		
	},Report: function(){
		var aForm = document.getElementById(this.prefix+('_form'));		
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		var url2 = this.url;
		$.ajax({
			type:'POST', 
			data: { jenisKegiatan : $("#jenisKegiatan").val(),
					c1 			  : $("#rkbmdPemeliharaan_v2SkpdfmUrusan").val(),
					c 			  : $("#rkbmdPemeliharaan_v2SkpdfmSKPD").val(),
					d 			  : $("#rkbmdPemeliharaan_v2SkpdfmUNIT").val(),
					e 			  : $("#rkbmdPemeliharaan_v2SkpdfmSUBUNIT").val(),
					e1 			  : $("#rkbmdPemeliharaan_v2SkpdfmSEKSI").val(),
					
					
					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					
					aForm.action= url2+'&tipe='+resp.content.to;	
					aForm.target='_blank';
					aForm.submit();	
					aForm.target='';
					me.Close();
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,		
	cancelKoreksi : function(id){
		rkbmdPemeliharaan_v2.refreshList(true);
	},
	excel:function(){
		var me = this;			
			var cover = this.prefix+'_formcover';
			document.body.style.overflow='hidden';
			if(me.satuan_form==0){//baru dari satuan
				addCoverPage2(cover,1,true,false);	
			}else{//baru dari barang
				addCoverPage2(cover,999,true,false);	
			}
			$.ajax({
				type:'POST', 
				data:$('#'+this.formName).serialize(),
			  	url: this.url+'&tipe=excel',
			  	success: function(data) {		
					var resp = eval('(' + data + ')');
					if(resp.err == ''){
						document.getElementById(cover).innerHTML = resp.content;
					}else{
						delElem(cover);
						alert(resp.err);
					}			
			
			  	}
			});
		
		
	},
	DownloadExcel: function(){
		var aForm = document.getElementById(this.prefix+('_form'));		
		var me= this;	
		this.OnErrorClose = false	
		document.body.style.overflow='hidden';
		var cover = this.prefix+'_formsimpan';
		addCoverPage2(cover,1,true,false);	
		var url2 = this.url;
		$.ajax({
			type:'POST', 
			data: { jenisKegiatan : $("#jenisKegiatan").val(),
					c1 			  : $("#rkbmdPemeliharaan_v2SkpdfmUrusan").val(),
					c 			  : $("#rkbmdPemeliharaan_v2SkpdfmSKPD").val(),
					d 			  : $("#rkbmdPemeliharaan_v2SkpdfmUNIT").val(),
					e 			  : $("#rkbmdPemeliharaan_v2SkpdfmSUBUNIT").val(),
					e1 			  : $("#rkbmdPemeliharaan_v2SkpdfmSEKSI").val(),
					
					
					},
			url: this.url+'&tipe=Report',
		  	success: function(data) {		
				var resp = eval('(' + data + ')');	
				delElem(cover);		
				if(resp.err==''){
					
					aForm.action= url2+'&tipe='+resp.content.to+"&xls=1";	
					aForm.target='_blank';
					aForm.submit();	
					aForm.target='';
					me.Close();
				}else{
					alert(resp.err);
				}
		  	}
		});
	}
	,
});
