<?php require __DIR__.'/assets/header.php'; ?>

	<div class="break clear"></div>
	<div class="left">
		<h3>&nbsp;</h3>
		<p>Code</p>
		<p>&nbsp;</p>
		<p>Output</p>
	</div>
	<div class="right">
		<h3>Authentricatron Secret</h3>
		<p><code>Authentricatron_Secret();</code></p>
		<p><code>Authentricatron_Secret($Length = 16);</code></p>
		<p>Returns a <code>$Length</code> long string with 32bit only Characters, or <code>false</code> on failure (usually security).</p>
		<p>For generating secrets. Usually accessed only from within the URL/QRCode functions</p>
		<p><code>$Length</code> should be an integer, longer than 16. Usually left to default.</p>
		<p>Generated using MCrypt if it is available, falling back to OpenSSL if it is secure.</p>
		<p>If returning <code>false</code>, try installing <code>php5-mcrypt</code> on Ubuntu.</p>
	</div>
	<?php
		if ( $_GET['debug'] ) {
			$MCrypt = false;
			$OpenSSL = false;
			echo '
	<div class="clear"></div>
	<div class="left">
		<p>Debug</p>
	</div>
	<div class="right">';
				if ( function_exists('mcrypt_create_iv') ) {
					$MCrypt = true;
					echo '
		<p class="color-nephritis">MCrypt is installed.</p>';
				} else {
					echo '
		<p class="color-pomegranate">MCrypt is not installed.</p>';
					if ( function_exists('openssl_random_pseudo_bytes') ) {
						$Random = openssl_random_pseudo_bytes($Length, $Strong);
						if ( $Strong ) {
							$OpenSSL = true;
							echo '
		<p class="color-nephritis">OpenSSL is installed, and secure.</p>';
						} else {
							echo '
		<p class="color-pomegranate">OpenSSL is installed, but not secure.</p>';
						}
					} else {
						echo '
		<p class="color-pomegranate">OpenSSL is not installed.</p>';
					}
				}
				if ( $MCrypt ) {
					echo '
		<p><strong>Your installation will use MCrypt.</strong></p>';
				} else if ( $OpenSSL ) {
					echo '
		<p><strong>Your installation will use OpenSSL.</strong></p>';
				} else {
					echo '
		<p class="color-nephritis"><strong>Your installation will not work.</strong></p>';
				}
			}
		echo '
	</div>';
		}
	?>

	<div class="break clear"></div>
	<div class="left">
		<h3>&nbsp;</h3>
		<p>Code</p>
		<p>&nbsp;</p>
		<p>Output</p>
	</div>
	<div class="right">
		<h3>Authentricatron URL</h3>
		<p><code>Authentricatron_URL($Member_Name, $Secret);</code></p>
		<p><code>Authentricatron_URL($Member_Name, $Secret, $Issuer = DEFAULT);</code></p>
		<p>Outputs an OTPAuth URL that gives people their Secret along with a passed Member Name and an optional Issuer.</p>
		<p>All parameters should be strings, with the optional issuer defaulting to the configured value if not passed.</p>
	</div>

	<div class="break clear"></div>
	<div class="left">
		<h3>&nbsp;</h3>
		<p>Code</p>
	</div>
	<div class="right">
		<h3>Authentricatron QR</h3>
		<p><code>Authentricatron_QR($URL);</code></p>
		<p><code>Authentricatron_QR($URL, $Size = 4);</code></p>
		<p><code>Authentricatron_QR($URL, $Size = 4, $Margin = 0);</code></p>
		<p><code>Authentricatron_QR($URL, $Size = 4, $Margin = 0, $Level = 'M');</code></p>
		<p><code>$URL</code> is a valid OTPAuth URL in string form.</p>
		<p><code>$Size</code> is a non-zero integer, defaults to 4.</p>
		<p><code>$Margin</code> is an integer, defaults to 0.</p>
		<p><code>$Level</code> is a string, defaults to 'M'. It defines the error correction level.</p>
		<ul>
			<li>Level L (Low) &emsp; 7% of codewords can be restored.</li>
			<li>Level M (Medium) &emsp; 15% of codewords can be restored.</li>
			<li>Level Q (Quartile) &emsp; 25% of codewords can be restored.</li>
			<li>Level H (High) &emsp; 30% of codewords can be restored.</li>
		</ul>
	</div>
	<div class="break"></div>
	<div class="left">
		<p>Output</p>
		<img alt="Google Authenticator Icon" src="assets/google_images-128.png">
	</div>
	<div class="right">
		<p>Outputs a QR Code image in 64bit data-URI form.</p>
		<?php
			if (
				extension_loaded('gd') &&
				function_exists('gd_info')
			) {
				echo '<!-- PHPQRCode -->';
				$QR_Base64 = Authentricatron_QR($URL);
				echo '
		<p><img src="'.$QR_Base64.'"></p>
		<p>This should open an app like <a href="https://m.google.com/authenticator">Google Authenticator</a>.</p>';
			} else {
				echo '
		<p class="color-pomegranate">The GD functions are not loaded.</p>
		<p>Try installing <code>php5-gd</code> in Ubuntu.</p>';
			}
		?>
	</div>
	
	<!-- TODO Rewrite from here. -->

	<div class="break clear"></div>
	<div class="left">
		<h3>&nbsp;</h3>
		<p>Code</p>
		<p>Output</p>
		<p>Information</p>
	</div>
	<div class="right">
		<h3>Base32 Decoded</h3>
		<p><code>Base32_Decode($Secret);</code></p>
		<p>You shouldn't need to be using this function, it's just part of the hashing.</p>
		<p>It also isn't decoding, at least not in any real sense.</p>
	</div>

	<div class="break clear"></div>
	<div class="left">
		<h3>&nbsp;</h3>
		<p>Code</p>
		<p>Output</p>
		<p>Information</p>
	</div>
	<div class="right">
		<h3>Current Code</h3>
		<p><code>Authentricatron_Code($Secret);</code></p>
		<p><pre><?php echo $Code; ?></pre></p>
		<p>This is the current authentication code.</p>
		<p>Check the Acceptable list to see the two either side.</p>
	</div>

	<?php $Acceptable = Authentricatron_Acceptable($Secret); ?>
	<div class="break clear"></div>
	<div class="left">
		<h3>&nbsp;</h3>
		<p>Code</p>
		<p>Output</p>
	</div>
	<div class="right">
		<h3>Acceptable Codes</h3>
		<p><code>Authentricatron_Acceptable($Secret);</code></p>
		<p><pre><?php var_dump($Acceptable); ?></pre></p>
	</div>
	<div class="clear"></div>
	<div class="left">
		<p>Information</p>
		<img alt="Vault Icon" src="assets/google_authenticator-128.png">
	</div>
	<div class="right">
		<p>This is the array <code>Authentricatron_Check</code> uses to check for valid codes.</p>
		<p><strong>Your phone should produce one of these from the QR code above.</strong></p>
		<p>These are only valid for 30 seconds, so click the Secret link to get a new list.</p>
	</div>

	<?php $Check =  Authentricatron_Check($Code, $Secret); ?>
	<div class="break clear"></div>
	<div class="left">
		<h3>&nbsp;</h3>
		<p>Code</p>
		<p>Output</p>
		<p>Information</p>
	</div>
	<div class="right">
		<h3>Check a Code</h3>
		<p><code>Authentricatron_Check($Code, $Secret);</code></p>
		<p><pre><?php var_dump($Check); ?></pre></p>
		<p>This returns a simple boolean value to prevent data-leakage and zero-equivalent values from codes or keys.</p>
	</div>

	<div class="break clear"></div>
	<div class="left">
		<h3>&nbsp;</h3>
		<p>Code</p>
		<p>&nbsp;</p>
		<p>Output</p>
		<p>Information</p>
	</div>
	<div class="right">
		<h3>Glossary</h3>
		<p><strong>Base32</strong> is an encoding, effectively an alphabet, that computers use made up of 32 characters.</p>
		<p><strong>Base32 Characters</strong> are A to Z (upper-case only), and 2 to 7.</p>
	</div>

	<div class="break clear"></div>


</body>
</html>