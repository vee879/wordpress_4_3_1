¥&V<?php exit; ?>a:6:{s:10:"last_error";s:0:"";s:10:"last_query";s:297:"
				SELECT meta_value, COUNT( * ) as meta_value_count FROM wp_commentmeta
				LEFT JOIN wp_comments ON wp_commentmeta.comment_id = wp_comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = 1056
				AND comment_approved = '1'
				AND meta_value > 0
				GROUP BY meta_value
			";s:11:"last_result";a:0:{}s:8:"col_info";a:2:{i:0;O:8:"stdClass":13:{s:4:"name";s:10:"meta_value";s:7:"orgname";s:10:"meta_value";s:5:"table";s:14:"wp_commentmeta";s:8:"orgtable";s:14:"wp_commentmeta";s:3:"def";s:0:"";s:2:"db";s:8:"Group3DB";s:7:"catalog";s:3:"def";s:10:"max_length";i:0;s:6:"length";i:4294967295;s:9:"charsetnr";i:45;s:5:"flags";i:32784;s:4:"type";i:252;s:8:"decimals";i:0;}i:1;O:8:"stdClass":13:{s:4:"name";s:16:"meta_value_count";s:7:"orgname";s:0:"";s:5:"table";s:0:"";s:8:"orgtable";s:0:"";s:3:"def";s:0:"";s:2:"db";s:0:"";s:7:"catalog";s:3:"def";s:10:"max_length";i:0;s:6:"length";i:21;s:9:"charsetnr";i:63;s:5:"flags";i:32769;s:4:"type";i:8;s:8:"decimals";i:0;}}s:8:"num_rows";i:0;s:10:"return_val";i:0;}