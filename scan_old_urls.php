<?php
function bdd_connect($state,$hote_mysql,$base_mysql,$user_mysql,$pass_mysql)
{
	if($state)
	{
		try
		{
		        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			$pdo_options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES utf8";
		        $bdd = new PDO('mysql:host='.$hote_mysql.';dbname='.$base_mysql, $user_mysql, $pass_mysql,$pdo_options);
		}
		catch (Exception $e)
		{
		        die('Error : ' . $e->getMessage());
		}
	}else{
		$bdd = NULL;
	}

	return $bdd;
}

function blog_picsfixpath_paths($bdd,$bdd_prefix = NULL ,$blog_id = NULL)
{
	if($blog_id != NULL)
	{
		$resultat = $bdd->query("select ID, post_content from ".$bdd_prefix.$blog_id."_posts where post_content LIKE \"%/wp-content/uploads/%\"");
		$resultat->setFetchMode(PDO::FETCH_OBJ);
		while( $ligne = $resultat->fetch() )
		{
			$post_replaced = str_replace("/uploads/", "/blogs.dir/".$blog_id."/files/", $ligne->post_content);
			$bdd->query("UPDATE ".$bdd_prefix.$blog_id."_posts SET post_content = \"".addslashes($post_replaced)."\" WHERE ID = ".$ligne->ID);
		}
		$bdd = common_bdd_connect(0);
	}else{
		echo "/!\ No blog defined";
	}
}

function blog_picsfix_urls($bdd,$bdd_prefix = NULL, $blog_id = NULL, $blog_baseurl = NULL, $blog_baseurl_new = NULL)
{
	if($blog_id != NULL || $blog_baseurl != NULL || $blog_baseurl_new != NULL)
	{
		$resultat = $bdd->query("select ID, post_content from ".$bdd_prefix.$blog_id."_posts where post_content LIKE \"%$blog_baseurl%\"");
		$resultat->setFetchMode(PDO::FETCH_OBJ);
		while( $ligne = $resultat->fetch() )
		{
			$post_replaced = str_replace($blog_baseurl, $blog_baseurl_new, $ligne->post_content);
			$bdd->query("UPDATE ".$bdd_prefix.$blog_id."_posts SET post_content = \"".addslashes($post_replaced)."\" WHERE ID = ".$ligne->ID);
		}
		$bdd = common_bdd_connect(0);
	}else{
		echo "/!\ No blog defined";
	}
}

$bdd = bdd_connect(1,"localhost","bddname","root","");
//echo blog_picsfix_urls($bdd,94,"blog.test.fr", "test.test2.fr");

?>
