<?php $i = 1; ?>
					@foreach($aturan as $item)
					<p>[R{{$i}}]
					<?php $j = 0; ?>
@foreach($detail as $item2)

								@if($item2->aturan_id == $item->id && $item2->status == 0)
									@if($j == 0)
										<b>IF</b>
									@endif
									{{$item2->nama_variable}} 
									{{$item2->nama_himpunan}}
									<b>AND</b>
									<?php $j++; ?>
								@elseif($item2->aturan_id == $item->id && $item2->status == 1)
									<b>THEN</b>
									{{$item2->nama_variable}} 
									{{$item2->nama_himpunan}}
								@endif
							
							@endforeach
							</p>
							<?php $i++; ?>
					@endforeach
