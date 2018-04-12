<div style="border-bottom:solid 3px black">
	<div style="width:50%;float:left;font-size:20pt" class="purple"><b>エネルギー使用量 仕上量(タオル室・ローラー・プレス)</b></div>
	<div style="width:30%;float:left;font-size:15pt" class="purple"><b>※仕上重量においては、月間生産概要にて別計算</b></div>
	<div style="width:20%;float:right;text-align: right;font-size:16pt;">
		<div style="margin-right:20px"><?= $this->helper->readDate(date('Y-m-d')) ?></div>
	</div>
</div>
<div style="clear:both;border-bottom:solid 3px black">
	<div style="width:50%;float:left;font-size:20pt"><?= $date_from." ~ ".$date_to ?></div>
	<div style="width:50%;float:right;text-align: right;font-size:20pt;">
		<div class="purple">単位：枚</div>
	</div>
</div>
<table style="width:95%;margin:20px">
	<tr>
		<td class="purple"><span class="padding">シーツ仕上前</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SHEET]) == true?$Master[FSD_SHEET]['total']:0 ?></td>
		<td class="purple center"><span class="padding">シーツしみ</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SHEETS]) == true?$Master[FSD_SHEETS]['total']:0 ?></td>
		<td class="purple center"><span class="padding">シーツ洗直し</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SHEET_WASH_AGAIN]) == true?$Master[FSD_SHEET_WASH_AGAIN]['total']:0 ?></td>
		<td class="purple center"><span class="padding">シーツ破れ</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SHEET_BREAKING]) == true?$Master[FSD_SHEET_BREAKING]['total']:0 ?></td>
	</tr>
	<tr >
		<td class="purple">(内5号機仕上)</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SHEETS_2]) == true?$Master[FSD_SHEETS_2]['total']:0 ?></td>
		<td class="purple"></td>
		<td ></td>
		<td class="purple"></td>
		<td ></td>
		<td class="purple"></td>
		<td ></td>
	</tr>
	<tr >
		<td colspan=8 class="border-dot"></td>
	</tr>
	<tr>
		<td class="purple">TOP仕上前</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_TOP]) == true?$Master[FSD_TOP]['total']:0 ?></td>
		<td class="purple center"><span class="padding">TOPしみ</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_TOP_STAINS]) == true?$Master[FSD_TOP_STAINS]['total']:0 ?></td>
		<td class="purple center"><span class="padding">TOP洗直し</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_TOP_WASH_AGAIN]) == true?$Master[FSD_TOP_WASH_AGAIN]['total']:0 ?></td>
		<td class="purple center"><span class="padding">TOP破れ</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_TOP_BREAK]) == true?$Master[FSD_TOP_BREAK]['total']:0 ?></td>
	</tr>
	<tr>
		<td class="purple">(内5号機仕上)</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_TOP_2]) == true?$Master[FSD_TOP_2]['total']:0 ?></td>
		<td class="purple"></td>
		<td ></td>
		<td class="purple"></td>
		<td ></td>
		<td class="purple"></td>
		<td ></td>
	</tr>
	<tr >
		<td colspan=8 class="border-dot"></td>
	</tr>
	<tr>
		<td class="purple">デュベ仕上前</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_DUVE]) == true?$Master[FSD_DUVE]['total']:0 ?></td>
		<td class="purple center"><span class="padding">デュベしみ</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_DUVES_STAIN]) == true?$Master[FSD_DUVES_STAIN]['total']:0 ?></td>
		<td class="purple center"><span class="padding">デュベ洗直し</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_DUVET_WASH_AGAIN]) == true?$Master[FSD_DUVET_WASH_AGAIN]['total']:0 ?></td>
		<td class="purple center"><span class="padding">デュベ破れ</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_DUVE_TEAR]) == true?$Master[FSD_DUVE_TEAR]['total']:0 ?></td>
	</tr>
	<tr>
		<td class="purple">(内5号機仕上)</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_DUVE_2]) == true?$Master[FSD_DUVE_2]['total']:0 ?></td>
		<td class="purple"></td>
		<td ></td>
		<td class="purple"></td>
		<td ></td>
		<td class="purple"></td>
		<td ></td>
	</tr>
	<tr >
		<td colspan=8 class="border-solid"></td>
	</tr>
	<tr>
		<td class="purple">ピロケース </td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_PIROCASE]) == true?$Master[FSD_PIROCASE]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr >
		<td colspan=8 class="border-solid"></td>
	</tr>
	<tr>
		<td class="purple">バスタオル(ﾌﾟｰﾙ含)</td>
		<td style="border:solid 1px black"><?= isset($Master[BT]) == true?$Master[BT]['total']:0 ?></td>
		<td class="purple center"><span class="padding">クリーナータオル</span></td>
		<td style="border:solid 1px black"><?= isset($Master[CT]) == true?$Master[CT]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr>
		<td class="purple">フェイスタオル</td>
		<td style="border:solid 1px black"><?= isset($Master[FT]) == true?$Master[FT]['total']:0 ?></td>
		<td class="purple center"><span class="padding">バスローブ</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_BATHROBES]) == true?$Master[FSD_BATHROBES]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr>
		<td class="purple">ウォッシュタオル</td>
		<td style="border:solid 1px black"><?= isset($Master[WT]) == true?$Master[WT]['total']:0 ?></td>
		<td class="purple center"><span class="padding">ベーシング</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_BASING]) == true?$Master[FSD_BASING]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr>
		<td class="purple">バスマット</td>
		<td style="border:solid 1px black"><?= isset($Master[BM]) == true?$Master[BM]['total']:0 ?></td>
		<td class="purple center"><span class="padding">ディッシュタオル</span></td>
		<td style="border:solid 1px black"><?= isset($Master[DT]) == true?$Master[DT]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr >
		<td colspan=8 class="border-solid"></td>
	</tr>
	<tr>
		<td class="purple">ナイトガウン</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_NIGHTGOWN]) == true?$Master[FSD_NIGHTGOWN]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr>
		<td class="purple">浴衣浴衣</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_FSD_YUKATA]) == true?$Master[FSD_FSD_YUKATA]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr>
		<td class="purple">フィットネス上下</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_TRAINER_AND_OTHERS]) == true?$Master[FSD_TRAINER_AND_OTHERS]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr >
		<td colspan=8 class="border-solid"></td>
	</tr>
	<tr>
		<td class="purple">甚平(上)</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_JINBEI_UPPER]) == true?$Master[FSD_JINBEI_UPPER]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr>
		<td class="purple">甚平(下) </td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_JINPING_BOTTOM]) == true?$Master[FSD_JINPING_BOTTOM]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr >
		<td colspan=8 class="border-solid"></td>
	</tr>
	<tr>
		<td class="purple">アカスリ</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_AKASURI]) == true?$Master[FSD_AKASURI]['total']:0 ?></td>
		<td class="purple center"><span class="padding">靴下</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SOCKS]) == true?$Master[FSD_SOCKS]['total']:0 ?></td>
		<td class="purple center"><span class="padding">ナプキン他</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_NAPKIN_AND_OTHERS]) == true?$Master[FSD_NAPKIN_AND_OTHERS]['total']:0 ?></td>
		<td class="purple center"><span class="padding">TDクロス2 </span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_TD_CROSS_2]) == true?$Master[FSD_TD_CROSS_2]['total']:0 ?></td>
	</tr>
	<tr >
		<td colspan=8 class="border-solid"></td>
	</tr>
	<tr>
		<td class="purple">短尺他</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SHORT_SCALE_2]) == true?$Master[FSD_SHORT_SCALE_2]['total']:0 ?></td>
		<td class="purple center"><span class="padding">短尺他しみ2</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SHORT_STUBBLE_2]) == true?$Master[FSD_SHORT_STUBBLE_2]['total']:0 ?></td>
		<td class="purple center"><span class="padding"> 短尺他洗直し2</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SHORT_SCALE_OTHER_WASH_2]) == true?$Master[FSD_SHORT_SCALE_OTHER_WASH_2]['total']:0 ?></td>
		<td class="purple center"><span class="padding"> 短尺他破れ2</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SHORT_SCALE_OTHER_CRACK_2]) == true?$Master[FSD_SHORT_SCALE_OTHER_CRACK_2]['total']:0 ?></td>
	</tr>
	<tr>
		<td class="purple">長尺他</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_OTHERS]) == true?$Master[FSD_OTHERS]['total']:0 ?></td>
		<td class="purple center"><span class="padding">長尺他しみ2</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_LONG_LENGTH_STAIN_2]) == true?$Master[FSD_LONG_LENGTH_STAIN_2]['total']:0 ?></td>
		<td class="purple center"><span class="padding">長尺他洗直し2</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_LONG_LENGTH_WASH_AGAIN_2]) == true?$Master[FSD_LONG_LENGTH_WASH_AGAIN_2]['total']:0 ?></td>
		<td class="purple center"><span class="padding">長尺他破れ2 </span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_LONG_RAKE_OTHER_TEAR_2]) == true?$Master[FSD_LONG_RAKE_OTHER_TEAR_2]['total']:0 ?></td>
	</tr>
	<tr>
		<td class="purple">ポリクロス</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_POLYCLOTH_2]) == true?$Master[FSD_POLYCLOTH_2]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>
	<tr >
		<td colspan=8 class="border-solid"></td>
	</tr>
	<tr>
		<td class="purple">白衣</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_WHITE_COAT]) == true?$Master[FSD_WHITE_COAT]['total']:0 ?></td>
		<td class="purple center"><span class="padding">ズボン</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_PANTS]) == true?$Master[FSD_PANTS]['total']:0 ?></td>
		<td class="purple center"><span class="padding">帽子</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_HAT]) == true?$Master[FSD_HAT]['total']:0 ?></td>
		<td class="purple center"><span class="padding">ワンピース</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_ONE_PIECE]) == true?$Master[FSD_ONE_PIECE]['total']:0 ?></td>
	</tr>
	<tr>
		<td class="purple">前掛</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_FRONT_HANGING]) == true?$Master[FSD_FRONT_HANGING]['total']:0 ?></td>
		<td class="purple center"><span class="padding">三角布</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_TRIANGULAR_CLOTH]) == true?$Master[FSD_TRIANGULAR_CLOTH]['total']:0 ?></td>
		<td class="purple center"><span class="padding">エプロン</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_APRON]) == true?$Master[FSD_APRON]['total']:0 ?></td>
		<td class="purple center"><span class="padding">スリッパ</span></td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_SLIPPER]) == true?$Master[FSD_SLIPPER]['total']:0 ?></td>
	</tr>
	<tr>
		<td class="purple">星製薬</td>
		<td style="border:solid 1px black"><?= isset($Master[FSD_STAR_PHARMACEUTICAL]) == true?$Master[FSD_STAR_PHARMACEUTICAL]['total']:0 ?></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
		<td class="purple center"><span class="padding"></span></td>
		<td ></td>
	</tr>

</table>
<style>
	body{
		font-size:13pt;
		font-weight: bold;
	}
	table{
		border-spacing: 0 0.3em;
	}
	td,th{
		text-align: left
	}
	.purple{
		color:#25258e;

	}
	td{
		
	}
	.center{
		text-align: center;
	}
	.border-dot{
		border-bottom:dotted 1px black;
	}
	.border-solid{
		border-bottom:solid 1px black;
	}
	
</style>