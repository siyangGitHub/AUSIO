<div class="users login form">
    <?= $this->Flash->render() ?>
    <?= $this->Form->create(null, ['id' => 'loginForm', 'autocomplete' => 'on']) ?>
    <fieldset>
        <legend><?= __('Login') ?></legend>
        <div class="input text required">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" autocomplete="username"/>
        </div>
        <div class="input password required">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" autocomplete="current-password"/>
        </div>
    </fieldset>
    <button id='loginButton' type="submit" class="btn btn-green">Log in</button>
    <div class="divider">or</div>
    <a href="<?php echo $this->Url->build([
        "controller" => "Users",
        "action" => "add",
    ]); ?>" type="button" class="btn btn-blue">Sign up</a>
    <?= $this->Form->end() ?>
</div>

