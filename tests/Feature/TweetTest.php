<?php
// ? �ǉ�
use App\Models\Tweet;
use App\Models\User;

// ?�ꗗ�擾�̃e�X�g
it('displays tweets', function () {
  // ���[�U���쐬
  $user = User::factory()->create();

  // ���[�U��F��
  $this->actingAs($user);

  // Tweet���쐬
  $tweet = Tweet::factory()->create();

  // GET���N�G�X�g
  $response = $this->get('/tweets');

  // ���X�|���X��Tweet�̓��e�Ɠ��e�Җ����܂܂�Ă��邱�Ƃ��m�F
  $response->assertStatus(200);
  $response->assertSee($tweet->tweet);
  $response->assertSee($tweet->user->name);
});

// �쐬��ʂ̃e�X�g
it('displays the create tweet page', function () {
  // �e�X�g�p�̃��[�U�[���쐬
  $user = User::factory()->create();

  // ���[�U�[��F�؁i���O�C���j
  $this->actingAs($user);

  // �쐬��ʂɃA�N�Z�X
  $response = $this->get('/tweets/create');

  // �X�e�[�^�X�R�[�h��200�ł��邱�Ƃ��m�F
  $response->assertStatus(200);
});
// �쐬�����̃e�X�g
it('allows authenticated users to create a tweet', function () {
  // ���[�U���쐬
  $user = User::factory()->create();

  // ���[�U��F��
  $this->actingAs($user);

  // Tweet���쐬
  $tweetData = ['tweet' => 'This is a test tweet.'];

  // POST���N�G�X�g
  $response = $this->post('/tweets', $tweetData);

  // �f�[�^�x�[�X�ɕۑ����ꂽ���Ƃ��m�F
  $this->assertDatabaseHas('tweets', $tweetData);

  // ���X�|���X�̊m�F
  $response->assertStatus(302);
  $response->assertRedirect('/tweets');
});
// �ڍ׉�ʂ̃e�X�g
it('displays a tweet', function () {
  // ���[�U���쐬
  $user = User::factory()->create();

  // ���[�U��F��
  $this->actingAs($user);

  // Tweet���쐬
  $tweet = Tweet::factory()->create();

  // GET���N�G�X�g
  $response = $this->get("/tweets/{$tweet->id}");

  // ���X�|���X��Tweet�̓��e���܂܂�Ă��邱�Ƃ��m�F
  $response->assertStatus(200);
  $response->assertSee($tweet->tweet);
  $response->assertSee($tweet->created_at->format('Y-m-d H:i'));
  $response->assertSee($tweet->updated_at->format('Y-m-d H:i'));
  $response->assertSee($tweet->tweet);
  $response->assertSee($tweet->user->name);
});
// �ҏW��ʂ̃e�X�g
it('displays the edit tweet page', function () {
  // �e�X�g�p�̃��[�U�[���쐬
  $user = User::factory()->create();

  // ���[�U�[��F�؁i���O�C���j
  $this->actingAs($user);

  // Tweet���쐬
  $tweet = Tweet::factory()->create(['user_id' => $user->id]);

  // �ҏW��ʂɃA�N�Z�X
  $response = $this->get("/tweets/{$tweet->id}/edit");

  // �X�e�[�^�X�R�[�h��200�ł��邱�Ƃ��m�F
  $response->assertStatus(200);

  // �r���[��Tweet�̓��e���܂܂�Ă��邱�Ƃ��m�F
  $response->assertSee($tweet->tweet);
});
// �X�V�����̃e�X�g
it('allows a user to update their tweet', function () {
  // ���[�U���쐬
  $user = User::factory()->create();

  // ���[�U��F��
  $this->actingAs($user);

  // Tweet���쐬
  $tweet = Tweet::factory()->create(['user_id' => $user->id]);

  // �X�V�f�[�^
  $updatedData = ['tweet' => 'Updated tweet content.'];

  // PUT���N�G�X�g
  $response = $this->put("/tweets/{$tweet->id}", $updatedData);

  // �f�[�^�x�[�X���X�V���ꂽ���Ƃ��m�F
  $this->assertDatabaseHas('tweets', $updatedData);

  // ���X�|���X�̊m�F
  $response->assertStatus(302);
  $response->assertRedirect("/tweets/{$tweet->id}");
});
// �폜�����̃e�X�g
it('allows a user to delete their tweet', function () {
  // ���[�U���쐬
  $user = User::factory()->create();

  // ���[�U��F��
  $this->actingAs($user);

  // Tweet���쐬
  $tweet = Tweet::factory()->create(['user_id' => $user->id]);

  // DELETE���N�G�X�g
  $response = $this->delete("/tweets/{$tweet->id}");

  // �f�[�^�x�[�X����폜���ꂽ���Ƃ��m�F
  $this->assertDatabaseMissing('tweets', ['id' => $tweet->id]);

  // ���X�|���X�̊m�F
  $response->assertStatus(302);
  $response->assertRedirect('/tweets');
});
