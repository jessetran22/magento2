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
 * @Title("[NO TESTCASEID]: Admin can not create rule with invalid data")
 * @Description("Admin can not create rule with invalid data<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/AdminCreateInvalidRuleTest.xml<br>")
 * @group SalesRule
 */
class AdminCreateInvalidRuleTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Stories({"Create cart price rule with invalid data"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateInvalidRuleTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales_rule/promo_quote/"); // stepKey: openCartPriceRulesPageAmOnCartPriceList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCartPriceList
		$I->comment("Exiting Action Group [amOnCartPriceList] AdminOpenCartPriceRulesPageActionGroup");
		$I->click("#add"); // stepKey: clickAddNewRule
		$I->waitForPageLoad(30); // stepKey: clickAddNewRuleWaitForPageLoad
		$I->click("div[data-index='actions']"); // stepKey: clickToExpandActions
		$I->waitForPageLoad(30); // stepKey: clickToExpandActionsWaitForPageLoad
		$I->selectOption("select[name='simple_action']", "Buy X get Y free (discount amount is Y)"); // stepKey: selectActionType
		$I->fillField("input[name='discount_amount']", "one"); // stepKey: fillDiscountAmount
		$I->fillField("input[name='discount_qty']", "one"); // stepKey: fillDiscountQty
		$I->fillField("input[name='discount_step']", "one"); // stepKey: fillDiscountStep
		$I->fillField("//input[@name='uses_per_customer']", "one"); // stepKey: fillUsePerCustomer
		$I->selectOption("select[name='coupon_type']", "Specific Coupon"); // stepKey: selectCouponType
		$I->fillField("//input[@name='uses_per_coupon']", "one"); // stepKey: fillUsePerCoupon
		$I->fillField("//*[@name='sort_order']", "one"); // stepKey: fillPriority
		$I->click("#save"); // stepKey: clickSaveButton
		$I->waitForPageLoad(30); // stepKey: clickSaveButtonWaitForPageLoad
		$I->see("Please enter a valid number in this field.", "//input[@name='uses_per_coupon']/following-sibling::label[@class='admin__field-error']"); // stepKey: seePerCouponError
		$I->see("Please enter a valid number in this field.", "//input[@name='uses_per_customer']/following-sibling::label[@class='admin__field-error']"); // stepKey: seePerCustomerError
		$I->see("Please enter a valid number in this field.", "//input[@name='sort_order']/following-sibling::label[@class='admin__field-error']"); // stepKey: seePriorityError
		$I->see("Please enter a valid number in this field.", "//input[@name='discount_amount']/following-sibling::label[@class='admin__field-error']"); // stepKey: seeDiscountAmountError
		$I->see("Please enter a valid number in this field.", "//input[@name='discount_qty']/following-sibling::label[@class='admin__field-error']"); // stepKey: seeMaximumQtyError
		$I->see("Please enter a valid number in this field.", "//input[@name='discount_step']/following-sibling::label[@class='admin__field-error']"); // stepKey: seeDiscountStepError
	}
}
