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
 * @Title("MC-15449: Delete Active Sales Rule With Percent Price And Verify Delete Message")
 * @Description("Test log in to Cart Price Rule and Delete Active Sales Rule Test<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminDeleteActiveSalesRuleWithPercentPriceAndVerifyDeleteMessageTest.xml<br>")
 * @TestCaseId("MC-15449")
 * @group salesRule
 * @group mtf_migrated
 */
class AdminDeleteActiveSalesRuleWithPercentPriceAndVerifyDeleteMessageTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create active cart price rule");
		$I->comment("Entering Action Group [createActiveCartPriceRule] AdminCreateCartPriceRuleWithCouponCodeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListCreateActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListCreateActiveCartPriceRule
		$I->click("#add"); // stepKey: clickAddNewRuleCreateActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleCreateActiveCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("input[name='name']", 30); // stepKey: waitRuleNameFieldAppearedCreateActiveCartPriceRule
		$I->fillField("input[name='name']", "Cart Price Rule with Specific Coupon" . msq("ActiveSalesRuleWithPercentPriceDiscountCoupon")); // stepKey: fillRuleNameCreateActiveCartPriceRule
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponTypeCreateActiveCartPriceRule
		$I->waitForElementVisible("input[name='coupon_code']", 30); // stepKey: waitForElementVisibleCreateActiveCartPriceRule
		$I->fillField("input[name='coupon_code']", "123-abc-ABC-987" . msq("ActiveSalesRuleWithPercentPriceDiscountCoupon")); // stepKey: fillCouponCodeCreateActiveCartPriceRule
		$I->fillField("//input[@name='uses_per_coupon']", "99"); // stepKey: fillUserPerCouponCreateActiveCartPriceRule
		$I->selectOption("select[name='website_ids']", "Main Website"); // stepKey: selectWebsitesCreateActiveCartPriceRule
		$I->selectOption("select[name='customer_group_ids']", ['NOT LOGGED IN']); // stepKey: selectCustomerGroupCreateActiveCartPriceRule
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActionsCreateActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsCreateActiveCartPriceRuleWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Fixed amount discount for whole cart"); // stepKey: selectActionTypeToFixedCreateActiveCartPriceRule
		$I->fillField("input[name='discount_amount']", "1"); // stepKey: fillDiscountAmountCreateActiveCartPriceRule
		$I->click("#save"); // stepKey: clickSaveButtonCreateActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonCreateActiveCartPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageCreateActiveCartPriceRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: seeSuccessMessageCreateActiveCartPriceRule
		$I->comment("Exiting Action Group [createActiveCartPriceRule] AdminCreateCartPriceRuleWithCouponCodeActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Stories({"Delete Sales Rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"SalesRule"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteActiveSalesRuleWithPercentPriceAndVerifyDeleteMessageTest(AcceptanceTester $I)
	{
		$I->comment("Delete active cart price rule");
		$I->comment("Entering Action Group [deleteActiveCartPriceRule] DeleteCartPriceRuleByName");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: amOnCartPriceListDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceListDeleteActiveCartPriceRule
		$I->fillField("input[name='name']", "Cart Price Rule with Specific Coupon" . msq("ActiveSalesRuleWithPercentPriceDiscountCoupon")); // stepKey: filterByNameDeleteActiveCartPriceRule
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: doFilterDeleteActiveCartPriceRuleWaitForPageLoad
		$I->click("tr[data-role='row']:nth-of-type(1)"); // stepKey: goToEditRulePageDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: goToEditRulePageDeleteActiveCartPriceRuleWaitForPageLoad
		$I->click("button#delete"); // stepKey: clickDeleteButtonDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteActiveCartPriceRuleWaitForPageLoad
		$I->click("button.action-accept"); // stepKey: confirmDeleteDeleteActiveCartPriceRule
		$I->waitForPageLoad(30); // stepKey: confirmDeleteDeleteActiveCartPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteActiveCartPriceRule] DeleteCartPriceRuleByName");
		$I->comment("Go to grid and verify AssertCartPriceRuleIsNotPresentedInGrid");
		$I->comment("Entering Action Group [searchAndVerifyActiveCartPriceRuleNotInGrid] AdminCartPriceRuleNotInGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchAndVerifyActiveCartPriceRuleNotInGridWaitForPageLoad
		$I->fillField("input[name='name']", "Cart Price Rule with Specific Coupon" . msq("ActiveSalesRuleWithPercentPriceDiscountCoupon")); // stepKey: filterByNameSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: doFilterSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->waitForPageLoad(30); // stepKey: doFilterSearchAndVerifyActiveCartPriceRuleNotInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoreToLoadSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td"); // stepKey: seeAssertCartPriceRuleIsNotPresentedInGridSearchAndVerifyActiveCartPriceRuleNotInGrid
		$I->comment("Exiting Action Group [searchAndVerifyActiveCartPriceRuleNotInGrid] AdminCartPriceRuleNotInGridActionGroup");
	}
}
