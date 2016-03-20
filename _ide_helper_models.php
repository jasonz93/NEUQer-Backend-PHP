<?php
/**
 * An helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace NEUQer{
/**
 * NEUQer\BBSBoard
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $picture
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSBoard whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSBoard whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSBoard whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSBoard wherePicture($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSBoard whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSBoard whereUpdatedAt($value)
 */
	class BBSBoard extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\BBSLike
 *
 * @property integer $id
 * @property integer $likeable_id
 * @property string $likeable_type
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $likeable
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSLike whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSLike whereLikeableId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSLike whereLikeableType($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSLike whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSLike whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSLike whereUpdatedAt($value)
 */
	class BBSLike extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\BBSOperation
 *
 * @property integer $id
 * @property integer $entity_id
 * @property string $entity_type
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $entity
 * @property-read \NEUQer\User $user
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSOperation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSOperation whereEntityId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSOperation whereEntityType($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSOperation whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSOperation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSOperation whereUpdatedAt($value)
 */
	class BBSOperation extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\BBSReply
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $topic_id
 * @property integer $reply_id
 * @property string $content
 * @property string $pictures
 * @property integer $floor
 * @property string $oldid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\BBSTopic $topic
 * @property-read \NEUQer\User $user
 * @property-read \NEUQer\BBSReply $reply
 * @property-read \Illuminate\Database\Eloquent\Collection|\NEUQer\BBSLike[] $likes
 * @property-read \NEUQer\BBSOperation $removed
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply whereTopicId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply whereReplyId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply wherePictures($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply whereFloor($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply whereOldid($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSReply whereUpdatedAt($value)
 */
	class BBSReply extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\BBSTopic
 *
 * @property integer $id
 * @property integer $board_id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property string $pictures
 * @property integer $view_count
 * @property integer $last_reply_id
 * @property string $oldid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\User $user
 * @property-read \NEUQer\BBSBoard $board
 * @property-read \NEUQer\BBSReply $lastReply
 * @property-read \Illuminate\Database\Eloquent\Collection|\NEUQer\BBSLike[] $likes
 * @property-read \NEUQer\BBSOperation $removed
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereBoardId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic wherePictures($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereViewCount($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereLastReplyId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereOldid($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\BBSTopic whereUpdatedAt($value)
 */
	class BBSTopic extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\CETAdmission
 *
 * @property integer $id
 * @property string $exam_code
 * @property integer $user_id
 * @property integer $weixin_user_id
 * @property string $number
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\User $user
 * @property-read \NEUQer\WeixinUser $weixinUser
 * @property-read \NEUQer\CETScore $score
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETAdmission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETAdmission whereExamCode($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETAdmission whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETAdmission whereWeixinUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETAdmission whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETAdmission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETAdmission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETAdmission whereUpdatedAt($value)
 */
	class CETAdmission extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\CETConfig
 *
 * @property string $mp_id
 * @property string $template_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\Wx3rdMP $mp
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETConfig whereMpId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETConfig whereTemplateId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETConfig whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETConfig whereUpdatedAt($value)
 */
	class CETConfig extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\CETScore
 *
 * @property integer $admission_id
 * @property integer $total
 * @property integer $listen
 * @property integer $read
 * @property integer $write
 * @property string $school
 * @property string $type
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\CETAdmission $admission
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereAdmissionId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereListen($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereWrite($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereSchool($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\CETScore whereUpdatedAt($value)
 */
	class CETScore extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\HomeMessage
 *
 * @property integer $id
 * @property string $banner
 * @property string $icon
 * @property string $title
 * @property string $subtitle
 * @property string $type
 * @property string $param
 * @property integer $author_id
 * @property integer $position
 * @property boolean $is_banner
 * @property boolean $show
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereBanner($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereSubtitle($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereParam($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereAuthorId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereIsBanner($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereShow($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\HomeMessage whereUpdatedAt($value)
 */
	class HomeMessage extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\KV
 *
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\KV whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\KV whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\KV whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\KV whereUpdatedAt($value)
 */
	class KV extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\Permission
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\NEUQer\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Permission whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Permission whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\Role
 *
 * @property integer $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\NEUQer\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\NEUQer\Permission[] $perms
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Role whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Role whereDisplayName($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Role whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\User
 *
 * @property integer $id
 * @property string $nickname
 * @property string $email
 * @property string $mobile
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $sign
 * @property string $avatar
 * @property string $sex
 * @property string $oldid
 * @property-read \Illuminate\Database\Eloquent\Collection|\NEUQer\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereSign($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\User whereOldid($value)
 */
	class User extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\UserToken
 *
 * @property integer $user_id
 * @property string $client
 * @property string $token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\User $user
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\UserToken whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\UserToken whereClient($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\UserToken whereToken($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\UserToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\UserToken whereUpdatedAt($value)
 */
	class UserToken extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\WeixinOAuth
 *
 * @property integer $weixin_user_id
 * @property string $scope
 * @property string $access_token
 * @property string $refresh_token
 * @property integer $expires_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\WeixinUser $weixinUser
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinOAuth whereWeixinUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinOAuth whereScope($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinOAuth whereAccessToken($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinOAuth whereRefreshToken($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinOAuth whereExpiresAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinOAuth whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinOAuth whereUpdatedAt($value)
 */
	class WeixinOAuth extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\WeixinUser
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $mp_id
 * @property string $openid
 * @property string $unionid
 * @property string $nickname
 * @property string $avatar
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\User $user
 * @property-read \NEUQer\Wx3rdMP $mp
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinUser whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinUser whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinUser whereMpId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinUser whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinUser whereUnionid($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinUser whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinUser whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\WeixinUser whereUpdatedAt($value)
 */
	class WeixinUser extends \Eloquent {}
}

namespace NEUQer{
/**
 * NEUQer\Wx3rdMP
 *
 * @property string $app_id
 * @property integer $user_id
 * @property string $nickname
 * @property string $avatar
 * @property string $username
 * @property string $alias
 * @property string $qrcode_url
 * @property string $access_token
 * @property integer $expires_at
 * @property string $refresh_token
 * @property integer $service_type
 * @property integer $verify_type
 * @property string $func_infos
 * @property boolean $open_store
 * @property boolean $open_scan
 * @property boolean $open_pay
 * @property boolean $open_card
 * @property boolean $open_shake
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \NEUQer\User $user
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereAppId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereAlias($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereQrcodeUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereAccessToken($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereExpiresAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereRefreshToken($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereServiceType($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereVerifyType($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereFuncInfos($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereOpenStore($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereOpenScan($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereOpenPay($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereOpenCard($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereOpenShake($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\NEUQer\Wx3rdMP whereUpdatedAt($value)
 */
	class Wx3rdMP extends \Eloquent {}
}

