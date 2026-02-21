    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->date('due_date')->nullable()->change();
            $table->string('priority')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->date('due_date')->nullable(false)->change();
            $table->string('priority')->nullable(false)->change();
        });
    }
};
