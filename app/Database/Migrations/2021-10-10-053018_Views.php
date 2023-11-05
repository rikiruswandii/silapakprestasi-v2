<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Views extends Migration
{
    private $views = [
        'view_news',
        'view_categories',
        'view_products',
        'view_innovations',
        'view_investments'
    ];

    public function up()
    {
        $news = "CREATE VIEW view_news AS
			SELECT news.id,
				news.title,
				news.slug,
				news.content,
				news.thumbnail,
				news.views,
				categories.slug AS slugcat,
				categories.name AS category,
				news.created_at,
				news.updated_at
			FROM news
			JOIN (
				SELECT id, slug, name
				FROM categories
				WHERE deleted_at IS NULL
			) AS categories
			ON categories.id = category
			WHERE deleted_at IS NULL";
        $this->db->query($news);

        $categories = "CREATE VIEW view_categories AS
			SELECT categories.id,
				categories.name,
				categories.slug,
				COALESCE(news.total, 0) AS total,
				categories.created_at,
				categories.updated_at
			FROM categories
			LEFT JOIN (
				SELECT COUNT(category) AS total,
					category
				FROM news
				WHERE deleted_at IS NULL
				GROUP BY category
			) AS news
			ON categories.id = category
			WHERE deleted_at IS NULL";
        $this->db->query($categories);

        $products = "CREATE VIEW view_products AS
			SELECT id,
				title,
				slug,
				content,
				thumbnail,
				views,
				created_at,
				updated_at,
				deleted_at,
				'investment' AS type
				FROM investments
				WHERE deleted_at IS NULL
			UNION ALL
			SELECT id,
				title,
				slug,
				content,
				thumbnail,
				views,
				created_at,
				updated_at,
				deleted_at,
				'profile' AS type
				FROM profiles
				WHERE deleted_at IS NULL
			UNION ALL
			SELECT id,
				title,
				slug,
				content,
				thumbnail,
				views,
				created_at,
				updated_at,
				deleted_at,
				'innovation' AS type
				FROM innovations
				WHERE deleted_at IS NULL";
        $this->db->query($products);

        $innovations = "CREATE VIEW view_innovations AS
			SELECT innovations.id,
				innovations.title,
				innovations.slug,
				innovations.content,
				innovations.pdf,
				profiles.id AS code,
				profiles.title AS instance,
				innovations.thumbnail,
				innovations.views,
				innovations.created_at,
				innovations.updated_at
			FROM innovations
			LEFT JOIN (
				SELECT id, title
				FROM profiles
				WHERE deleted_at IS NULL
			) AS profiles
			ON profiles.id = innovations.instance
			WHERE deleted_at IS NULL";
        $this->db->query($innovations);

        $investments = "CREATE VIEW view_investments AS
			SELECT investments.id,
				investments.title,
				investments.slug,
				sectors.id AS idsector,
				sectors.slug AS slugsector,
				sectors.name AS sector,
				investments.content,
				investments.thumbnail,
				investments.views,
				investments.created_at,
				investments.updated_at
			FROM investments
			LEFT JOIN (
				SELECT sectors.id,
					CASE WHEN sectors.parent IS NULL THEN sectors.slug ELSE parents.slug END AS slug,
					CASE WHEN sectors.parent IS NULL THEN sectors.name ELSE parents.name END AS name
				FROM sectors
				LEFT JOIN (
					SELECT id, name, slug, parent
					FROM sectors
					WHERE deleted_at IS NULL
				) AS parents
				ON parents.id = sectors.parent
				WHERE deleted_at IS NULL
			) AS sectors
			ON sectors.id = sector
			WHERE deleted_at IS NULL";
        $this->db->query($investments);
    }

    public function down()
    {
        // drop all view
        foreach ($this->views as $view) {
            $this->db->query("DROP VIEW IF EXISTS $view");
        }
    }
}
