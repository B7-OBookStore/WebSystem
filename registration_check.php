<?php
	$id = $_POST['id'];
?>

<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="widh3=device-widh3,initial-scale=1">
		<link rel="stylesheet" href="css/register.css">
		<link rel="icon" href="img/favicon.ico">
		<script src="js/register.js"></script>
		<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
		<title>O書店</title>
	</head>

	<body>

		<header>
			<h1><a href="index.php">O書店</a></h1>
			<span>Web注文機能を使うためには、ログインしてください</span>
			<a id="login" href="">ログイン</a>
		</header>

		<form id="search" method="get" action="search.php">
			<input name="q" type="search" placeholder="書籍を検索">
			<input type="submit" value="">
		</form>

		<div id="main">
			<section>
				<h2>会員登録</h2>
				<form action="registration_check.php" method="post">
					<div id="form" class="vertical">
						<div id="id" class="horizontal">
							<h3>ID</h3>
							<div>
								<input type="text" name="id" maxlength="11" required>
								<small>11文字以内　(例) abcd1234</small>
							</div>

						</div>
						<div id="password" class="horizontal">
							<h3>パスワード</h3>
							<div>
								<input type="password" maxlength="8" required>
								<small>8文字以上</small>
							</div>
						</div>

						<div id="sex" class="horizontal">
							<h3>性別</h3>
							<div class="horizontal">
								<input type="radio" name="sex" value="male">男
								<input type="radio" name="sex" value="female">女
							</div>
						</div>

						<div id="name" class="horizontal">
							<h3>氏名</h3>
							<div>
								<div class="horizontal">
									<div>
										<h4>性</h4>
										<input type="text" name="name" required>
										<small>(例) 静岡</small>
									</div>
									<div>
										<h4>名</h4>
										<input type="text" name="name" required>
										<small>(例) 太郎</small>
									</div>
								</div>
							</div>
						</div>

						<div id="phonetic" class="horizontal">
							<h3>フリガナ</h3>
							<div>
								<div class="horizontal">
									<div>
										<h4>性</h4>
										<input type="text" name="phonetic" required>
										<small>(例) シズオカ</small>
									</div>
									<div>
										<h4>名</h4>
										<input type="text" name="phonetic" required>
										<small>(例) タロウ</small>
									</div>
								</div>
							</div>
						</div>

						<div id="birth" class="horizontal">
							<h3>生年月日</h3>
							<div class="horizontal">
								<select name="year" required>
									<option value="">--</option>
									<option value="1917">1917</option>
									<option value="1918">1918</option>
									<option value="1919">1919</option>
									<option value="1920">1920</option>
									<option value="1921">1921</option>
									<option value="1922">1922</option>
									<option value="1923">1923</option>
									<option value="1924">1924</option>
									<option value="1925">1925</option>
									<option value="1926">1926</option>
									<option value="1927">1927</option>
									<option value="1928">1928</option>
									<option value="1929">1929</option>
									<option value="1930">1930</option>
									<option value="1931">1931</option>
									<option value="1932">1932</option>
									<option value="1933">1933</option>
									<option value="1934">1934</option>
									<option value="1935">1935</option>
									<option value="1936">1936</option>
									<option value="1937">1937</option>
									<option value="1938">1938</option>
									<option value="1939">1939</option>
									<option value="1940">1940</option>
									<option value="1941">1941</option>
									<option value="1942">1942</option>
									<option value="1943">1943</option>
									<option value="1944">1944</option>
									<option value="1945">1945</option>
									<option value="1946">1946</option>
									<option value="1947">1947</option>
									<option value="1948">1948</option>
									<option value="1949">1949</option>
									<option value="1950">1950</option>
									<option value="1951">1951</option>
									<option value="1952">1952</option>
									<option value="1953">1953</option>
									<option value="1954">1954</option>
									<option value="1955">1955</option>
									<option value="1956">1956</option>
									<option value="1957">1957</option>
									<option value="1958">1958</option>
									<option value="1959">1959</option>
									<option value="1960">1960</option>
									<option value="1961">1961</option>
									<option value="1962">1962</option>
									<option value="1963">1963</option>
									<option value="1964">1964</option>
									<option value="1965">1965</option>
									<option value="1966">1966</option>
									<option value="1967">1967</option>
									<option value="1968">1968</option>
									<option value="1969">1969</option>
									<option value="1970">1970</option>
									<option value="1971">1971</option>
									<option value="1972">1972</option>
									<option value="1973">1973</option>
									<option value="1974">1974</option>
									<option value="1975">1975</option>
									<option value="1976">1976</option>
									<option value="1977">1977</option>
									<option value="1978">1978</option>
									<option value="1979">1979</option>
									<option value="1980">1980</option>
									<option value="1981">1981</option>
									<option value="1982">1982</option>
									<option value="1983">1983</option>
									<option value="1984">1984</option>
									<option value="1985">1985</option>
									<option value="1986">1986</option>
									<option value="1987">1987</option>
									<option value="1988">1988</option>
									<option value="1989">1989</option>
									<option value="1990">1990</option>
									<option value="1991">1991</option>
									<option value="1992">1992</option>
									<option value="1993">1993</option>
									<option value="1994">1994</option>
									<option value="1995">1995</option>
									<option value="1996">1996</option>
									<option value="1997">1997</option>
									<option value="1998">1998</option>
									<option value="1999">1999</option>
									<option value="2000">2000</option>
									<option value="2001">2001</option>
									<option value="2002">2002</option>
									<option value="2003">2003</option>
									<option value="2004">2004</option>
									<option value="2005">2005</option>
									<option value="2006">2006</option>
									<option value="2007">2007</option>
									<option value="2008">2008</option>
									<option value="2009">2009</option>
									<option value="2010">2010</option>
									<option value="2011">2011</option>
									<option value="2012">2012</option>
									<option value="2013">2013</option>
									<option value="2014">2014</option>
									<option value="2015">2015</option>
									<option value="2016">2016</option>
									<option value="2017">2017</option>
									<option value="2018">2018</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
								</select>
								<p>年</p>
								<select name="monh3" required>
									<option value="">--</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select>
								<p>月</p>
								<select name="day" required>
									<option value="">--</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
									<option value="7">7</option>
									<option value="8">8</option>
									<option value="9">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
									<option value="13">13</option>
									<option value="14">14</option>
									<option value="15">15</option>
									<option value="16">16</option>
									<option value="17">17</option>
									<option value="18">18</option>
									<option value="19">19</option>
									<option value="20">20</option>
									<option value="21">21</option>
									<option value="22">22</option>
									<option value="23">23</option>
									<option value="24">24</option>
									<option value="25">25</option>
									<option value="26">26</option>
									<option value="27">27</option>
									<option value="28">28</option>
									<option value="29">29</option>
									<option value="30">30</option>
									<option value="31">31</option>
								</select>
								<p>日</p>
							</div>
						</div>

						<div id="phonenumber" class="horizontal">
							<h3>電話番号</h3>
							<div>
								<input type="text" name="phonenumber" maxlength="11" required>
								<small>(例) 12345678910</small>
							</div>
						</div>

						<div id="mailaddress" class="horizontal">
							<h3>メールアドレス</h3>
							<div class="horizontal"><input type="text" name="mailaddress" required>
								<p>@</p><input type="text" name="mailaddress" required>
							</div>
						</div>

						<div id="address" class="horizontal">
							<h3>住所</h3>

							<div>
								<div>
									<h4>郵便番号</h4>
									<div class="horizontal"><input type="text" class="addressnumber" name="addressnumber1" maxlength="3" required>
										<p>-</p><input type="text" class="addressnumber" name="addressnumber2" maxlength="4" required>
										<input id="button" type="button" value="〒" onclick="AjaxZip3.zip2addr('addressnumber1', 'addressnumber2', 'pref', 'city', 'city');">
									</div>
								</div>
								<div>

									<h4>都道府県</h4>
									<div>
										<select name="pref" required>
											<option value="">都道府県</option>
											<option value="北海道">北海道</option>
											<option value="青森県">青森県</option>
											<option value="秋田県">秋田県</option>
											<option value="岩手県">岩手県</option>
											<option value="山形県">山形県</option>
											<option value="宮城県">宮城県</option>
											<option value="福島県">福島県</option>
											<option value="山梨県">山梨県</option>
											<option value="長野県">長野県</option>
											<option value="新潟県">新潟県</option>
											<option value="富山県">富山県</option>
											<option value="石川県">石川県</option>
											<option value="福井県">福井県</option>
											<option value="茨城県">茨城県</option>
											<option value="栃木県">栃木県</option>
											<option value="群馬県">群馬県</option>
											<option value="埼玉県">埼玉県</option>
											<option value="千葉県">千葉県</option>
											<option value="東京都">東京都</option>
											<option value="神奈川県">神奈川県</option>
											<option value="愛知県">愛知県</option>
											<option value="静岡県">静岡県</option>
											<option value="岐阜県">岐阜県</option>
											<option value="三重県">三重県</option>
											<option value="大阪府">大阪府</option>
											<option value="兵庫県">兵庫県</option>
											<option value="京都府">京都府</option>
											<option value="滋賀県">滋賀県</option>
											<option value="奈良県">奈良県</option>
											<option value="和歌山県">和歌山県</option>
											<option value="岡山県">岡山県</option>
											<option value="広島県">広島県</option>
											<option value="鳥取県">鳥取県</option>
											<option value="島根県">島根県</option>
											<option value="山口県">山口県</option>
											<option value="徳島県">徳島県</option>
											<option value="香川県">香川県</option>
											<option value="愛媛県">愛媛県</option>
											<option value="高知県">高知県</option>
											<option value="福岡県">福岡県</option>
											<option value="佐賀県">佐賀県</option>
											<option value="長崎県">長崎県</option>
											<option value="熊本県">熊本県</option>
											<option value="大分県">大分県</option>
											<option value="宮崎県">宮崎県</option>
											<option value="鹿児島県">鹿児島県</option>
											<option value="沖縄県">沖縄県</option>
										</select>
									</div>
								</div>
								<div>
									<h4>市区町村</h4>
									<div><input type="text" name="city" required>
									</div>
								</div>

								<div>
									<h4>番地</h4>
									<div><input type="text" name="housenumber" required>
									</div>
								</div>
								<div>
									<h4>建物名など</h4>
									<div><input type="text" name="building">
									</div>
								</div>
							</div>
						</div>

						<input class="button_c" type="submit" value="送信">
					</div>
				</form>

				<img id="character" alt="O書店公式キャラクター 羽名しおりちゃん" src="img/register_shiori.png">
			</section>

		</div>

		<footer>
			<a href="">規約</a>
			<a href="">プライバシー</a>
			<a href="">店舗</a>
		</footer>


	</body>

</html>