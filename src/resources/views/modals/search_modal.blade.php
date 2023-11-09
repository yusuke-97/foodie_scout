<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="font-weight: bold;">条件で検索する</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('search') }}" method="get">
                    <div class="mb-3">
                        <label for="area" class="form-label">エリア・駅</label>
                        <input type="text" id="area" name="area" class="form-control" placeholder="エリア・駅 [例:渋谷]" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">ジャンル</label>
                        <input type="text" id="category" name="category" class="form-control" placeholder="ジャンル [例:寿司]" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="visit_date" class="form-label">日付</label>
                        <input type="date" id="visit_date" name="visit_date" class="form-control" value="{{ $date }}" min="{{ $date }}" max="{{ $lastDayOfTwoMonthsLater }}">
                    </div>

                    <div class="mb-3">
                        <label for="visit_time" class="form-label">時間</label>
                        <select id="visit_time" name="visit_time" class="form-select">
                            @foreach($times as $t)
                            <option value="{{ $t }}" @if($t=='17:00' ) selected @endif>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="number_of_guests" class="form-label">人数</label>
                        <select id="number_of_guests" name="number_of_guests" class="form-select">
                            @for($i = 1; $i <= 50; $i++) <option value="{{ $i }}" @if($i==2) selected @endif>{{ $i }}名</option>
                                @endfor
                        </select>
                    </div>

                    <button type="submit" class="btn submit-button">検索</button>
                </form>
            </div>
        </div>
    </div>
</div>