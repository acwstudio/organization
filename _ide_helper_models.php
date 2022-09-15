<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property int $region_id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property int $active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Organization[] $organizations
 * @property-read int|null $organizations_count
 * @property-read \App\Models\Region|null $region
 * @method static \Illuminate\Database\Eloquent\Builder|City findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FederalDistrict
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property int $active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Region[] $regions
 * @property-read int|null $regions_count
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict query()
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FederalDistrict withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 */
	class FederalDistrict extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Organization
 *
 * @property int $id
 * @property int $city_id
 * @property int $organization_type_id
 * @property string $name
 * @property string $abbreviation
 * @property string $description
 * @property string $site
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $slug
 * @property string $plaque_image
 * @property string $preview_image
 * @property string $base_image
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereBaseImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereOrganizationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization wherePlaqueImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization wherePreviewImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereUpdatedAt($value)
 */
	class Organization extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrganizationType
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property int $active
 * @property int $level
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|OrganizationType[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Organization[] $organizations
 * @property-read int|null $organizations_count
 * @property-read OrganizationType|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrganizationType withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 */
	class OrganizationType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Region
 *
 * @property int $id
 * @property int $federal_district_id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property int $active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @property-read int|null $cities_count
 * @property-read \App\Models\FederalDistrict|null $federalDistrict
 * @method static \Illuminate\Database\Eloquent\Builder|Region findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereFederalDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Region withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 */
	class Region extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

