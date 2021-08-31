<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-5299: Admin should be able to create a cart price rule with no starting date")
 * @Description("Admin should be able to create a cart price rule without specifying the from_date and it should be set with the current date<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminCreateCartPriceRuleEmptyFromDateTest.xml<br>")
 * @TestCaseId("MC-5299")
 * @group SalesRule
 */
class AdminCreateCartPriceRuleEmptyFromDateTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "SimpleProduct", ["category"], []); // stepKey: product
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete the cart price rule we made during the test");
		$I->comment("Entering Action Group [cleanUpRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCleanUpRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCleanUpRule
		$I->fillField("input[name='name']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: filterByNameCleanUpRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterCleanUpRule
		$I->waitForPageLoad(30); // stepKey: doFilterCleanUpRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageCleanUpRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageCleanUpRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonCleanUpRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonCleanUpRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteCleanUpRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteCleanUpRuleWaitForPageLoad
		$I->comment("Exiting Action Group [cleanUpRule] DeleteCartPriceRuleByName");
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("product", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"SalesRule"})
	 * @Stories({"Create cart price rule"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCartPriceRuleEmptyFromDateTest(AcceptanceTester $I)
	{
		$I->comment("Set timezone");
		$I->comment("Set timezone so we need compare with the same timezone used in \"generateDate\" action");
		$I->comment("Entering Action Group [goToGeneralConfig] AdminOpenGeneralConfigurationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: openGeneralConfigurationPageGoToGeneralConfig
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToGeneralConfig
		$I->comment("Exiting Action Group [goToGeneralConfig] AdminOpenGeneralConfigurationPageActionGroup");
		$I->wait(10); // stepKey: wait
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSection
		$originalTimezone = $I->grabValueFrom("#general_locale_timezone"); // stepKey: originalTimezone
		$I->selectOption("#general_locale_timezone", "America/Los_Angeles"); // stepKey: setTimezone
		$I->click("#save"); // stepKey: saveConfig
		$I->waitForPageLoad(30); // stepKey: saveConfigWaitForPageLoad
		$I->comment("Create a cart price rule based on a coupon code");
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->click("#add"); // stepKey: clickAddNewRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleWaitForPageLoad
		$I->fillField("input[name='name']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: fillRuleName
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsites
		$I->comment("Entering Action Group [selectCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B because B2B has a very different form control here");
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroupSelectCustomerGroup
		$I->comment("Exiting Action Group [selectCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponType
		$I->fillField("input[name='coupon_code']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: fillCouponCode
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActions
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Fixed amount discount for whole cart"); // stepKey: selectActionType
		$I->fillField("input[name='discount_amount']", "5"); // stepKey: fillDiscountAmount
		$I->click("#save"); // stepKey: clickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonWaitForPageLoad
		$I->comment("Verify initial successful save");
		$I->see("You saved the rule.", ".messages"); // stepKey: seeSuccessMessage
		$I->fillField("input[name='name']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: filterByName
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilter
		$I->waitForPageLoad(30); // stepKey: doFilterWaitForPageLoad
		$I->see("defaultCoupon" . msq("_defaultCoupon"), "td[data-column='name']"); // stepKey: seeRuleInResults
		$I->comment("Verify further on the Rule's edit page");
		$I->click("//*[@id='promo_quote_grid_table']/tbody/tr[td//text()[contains(., 'defaultCoupon" . msq("_defaultCoupon") . "')]]"); // stepKey: goToEditRule
		$I->waitForPageLoad(30); // stepKey: goToEditRuleWaitForPageLoad
		$I->seeInField("input[name='name']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: seeRuleName
		$I->seeOptionIsSelected("select[name='website_ids']", "Main Website"); // stepKey: seeWebsites
		$I->seeOptionIsSelected("select[name='coupon_type']", "Specific Coupon"); // stepKey: seeCouponType
		$I->seeInField("input[name='coupon_code']", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: seeCouponCode
		$date = new \DateTime();
		$date->setTimestamp(strtotime("now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$today = $date->format("m/j/Y");

		$I->seeInField("input[name='from_date']", "$today"); // stepKey: seeCorrectFromDate
		$I->seeInField("input[name='to_date']", ""); // stepKey: seeEmptyToDate
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActions2
		$I->waitForPageLoad(30); // stepKey: clickToExpandActions2WaitForPageLoad
		$I->seeOptionIsSelected("select[name='simple_action']", "Fixed amount discount for whole cart"); // stepKey: seeActionType
		$I->seeInField("input[name='discount_amount']", "5"); // stepKey: seeDiscountAmount
		$I->comment("Spot check the storefront");
		$I->amOnPage($I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("Entering Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCartPage
		$I->comment("Exiting Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [applyCoupon] StorefrontApplyCouponActionGroup");
		$I->waitForElement("#block-discount-heading", 30); // stepKey: waitForCouponHeaderApplyCoupon
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeaderApplyCoupon
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponFieldApplyCoupon
		$I->fillField("#coupon_code", "defaultCoupon" . msq("_defaultCoupon")); // stepKey: fillCouponFieldApplyCoupon
		$I->click("#discount-coupon-form button[class*='apply']"); // stepKey: clickApplyButtonApplyCoupon
		$I->waitForPageLoad(30); // stepKey: clickApplyButtonApplyCouponWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadApplyCoupon
		$I->comment("Exiting Action Group [applyCoupon] StorefrontApplyCouponActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad2
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
		$I->waitForElementVisible("td[data-th='Discount']", 30); // stepKey: waitForDiscountSeeDiscountTotal
		$I->see("-$5.00", "td[data-th='Discount']"); // stepKey: assertDiscountSeeDiscountTotal
		$I->comment("Exiting Action Group [seeDiscountTotal] AssertStorefrontCartDiscountActionGroup");
		$I->comment("Reset timezone");
		$I->comment("Entering Action Group [goToGeneralConfigReset] AdminOpenGeneralConfigurationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/general/"); // stepKey: openGeneralConfigurationPageGoToGeneralConfigReset
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToGeneralConfigReset
		$I->comment("Exiting Action Group [goToGeneralConfigReset] AdminOpenGeneralConfigurationPageActionGroup");
		$I->conditionalClick("#general_locale-head", "#general_locale_timezone", false); // stepKey: openLocaleSectionReset
		$I->selectOption("#general_locale_timezone", "$originalTimezone"); // stepKey: resetTimezone
		$I->click("#save"); // stepKey: saveConfigReset
		$I->waitForPageLoad(30); // stepKey: saveConfigResetWaitForPageLoad
	}
}
