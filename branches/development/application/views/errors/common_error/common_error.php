
	<div class="container">
		<div class="containerInner clearfix">

			<div class="content">
				<div class="contentInner" style="width:600px">

					<div class="contttlWrap">
						<h2>ERROR!!</h2>
					</div>

					<div class="tableWrap borderLesstable">
						<div class="descriArea">
							<p><?=$error_message?></p>
						</div>
						<div class="descriArea" style="text-align:right">
							<p>エラーコード：<?=$error_code?></p>
						</div>
						<div class="descriArea" style="text-align:center">
							<?php if(isset($back_url)): ?>
							<p><a href="<?=$back_url?>">戻る</a></p>
							<?php else: ?>
							<p><a href="javascript:history.back();">戻る</a></p>
							<?php endif ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
