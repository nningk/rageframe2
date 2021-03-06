<?php

use yii\db\Migration;

class m181110_033945_api_access_token extends Migration
{
    public function up()
    {
        /* 取消外键约束 */
        $this->execute('SET foreign_key_checks = 0');
        
        /* 创建表 */
        $this->createTable('{{%api_access_token}}', [
            'id' => 'bigint(20) unsigned NOT NULL AUTO_INCREMENT',
            'refresh_token' => 'varchar(60) NULL DEFAULT \'\' COMMENT \'刷新令牌\'',
            'access_token' => 'varchar(60) NULL DEFAULT \'\' COMMENT \'授权令牌\'',
            'member_id' => 'bigint(20) unsigned NULL COMMENT \'关联的用户id\'',
            'group' => 'varchar(30) NULL DEFAULT \'\' COMMENT \'组别\'',
            'allowance' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'规定时间可获取次数\'',
            'allowance_updated_at' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'最后一次提交时间\'',
            'status' => 'tinyint(4) NOT NULL DEFAULT \'1\' COMMENT \'状态[-1:删除;0:禁用;1启用]\'',
            'created_at' => 'int(10) NOT NULL DEFAULT \'0\' COMMENT \'创建时间\'',
            'updated_at' => 'int(10) NULL DEFAULT \'0\' COMMENT \'修改时间\'',
            'PRIMARY KEY (`id`)'
        ], "ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='api_授权秘钥表'");
        
        /* 索引设置 */
        $this->createIndex('access_token','{{%api_access_token}}','access_token',1);
        $this->createIndex('refresh_token','{{%api_access_token}}','refresh_token',1);
        
        
        /* 表数据 */
        
        /* 设置外键约束 */
        $this->execute('SET foreign_key_checks = 1;');
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks = 0');
        /* 删除表 */
        $this->dropTable('{{%api_access_token}}');
        $this->execute('SET foreign_key_checks = 1;');
    }
}

