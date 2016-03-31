<md-input-container>
    <label>关键词</label>
    <input type="text" name="keyword" placeholder="关键词" ng-model="handler.params.keyword">
</md-input-container>
<md-checkbox ng-model="handler.params.accurate">精确匹配</md-checkbox>
<md-input-container>
    <label>回复内容</label>
    <input type="text" name="content" placeholder="回复内容" ng-model="handler.params.content">
</md-input-container>