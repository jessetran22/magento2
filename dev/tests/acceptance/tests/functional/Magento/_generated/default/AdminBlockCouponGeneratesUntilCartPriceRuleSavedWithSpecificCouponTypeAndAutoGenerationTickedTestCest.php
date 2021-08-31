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
 * @Title("MC-42602: Block the coupon generates until cart price rule is saved with Specific Coupon type and Use Auto Generation ticked")
 * @Description("Block the coupon generates until cart price rule is saved with Specific Coupon type and Use Auto Generation ticked<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminBlockCouponGeneratesUntilCartPriceRuleSavedWithSpecificCouponTypeAndAutoGenerationTickedTest.xml<br>")
 * @TestCaseId("MC-42602")
 * @group salesRule
 */
class AdminBlockCouponGeneratesUntilCartPriceRuleSavedWithSpecificCouponTypeAndAutoGenerationTickedTestCest
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
		$I->createEntity("createSalesRule", "hook", "ApiCartRule", [], []); // stepKey: createSalesRule
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
		$I->deleteEntity("createSalesRule", "hook"); // stepKey: deleteSalesRule
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminBlockCouponGeneratesUntilCartPriceRuleSavedWithSpecificCouponTypeAndAutoGenerationTickedTest(AcceptanceTester $I)
	{
		$I->comment("Search Cart Price Rule and go to edit Cart Price Rule");
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->fillField("input[name='name']", $I->retrieveEntityField('createSalesRule', 'name', 'test')); // stepKey: fillFieldFilterByName
		$I->click("#promo_quote_grid button[title='Search']"); // stepKey: clickSearchButton
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonWaitForPageLoad
		$I->see($I->retrieveEntityField('createSalesRule', 'name', 'test'), "td[data-column='name']"); // stepKey: seeRuleName
		$I->click("//*[@id='promo_quote_grid_table']/tbody/tr[td//text()[contains(., '" . $I->retrieveEntityField('createSalesRule', 'name', 'test') . "')]]"); // stepKey: goToEditRule
		$I->waitForPageLoad(30); // stepKey: goToEditRuleWaitForPageLoad
		$I->comment("Choose coupon type specific coupon and tick auto generation checkbox");
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponType
		$I->checkOption("input[name='use_auto_generation']"); // stepKey: tickAutoGeneration
		$I->comment("Navigate to Manage Coupon Codes section to generate 1 coupon code");
		$I->conditionalClick("div[data-index='manage_coupon_codes']", "div[data-index='manage_coupon_codes']", true); // stepKey: clickManageCouponCodes
		$I->waitForPageLoad(30); // stepKey: clickManageCouponCodesWaitForPageLoad
		$I->fillField("#coupons_qty", "1"); // stepKey: fillFieldCouponQty
		$I->click("#coupons_generate_button"); // stepKey: clickGenerateCoupon
		$I->waitForPageLoad(30); // stepKey: clickGenerateCouponWaitForPageLoad
		$I->see("The rule coupon settings changed. Please save the rule before using auto-generation.", "aside.modal-popup div.modal-content div"); // stepKey: seeModalMessage
	}
}
