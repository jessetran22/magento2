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
 * @Title("MAGETWO-99012: Default Configuration for UPS Type")
 * @Description("Default Configuration for UPS Type<h3>Test files</h3>app/code/Magento/Ups/Test/Mftf/Test/DefaultConfigForUPSTypeTest.xml<br>")
 * @TestCaseId("MAGETWO-99012")
 * @group ups
 */
class DefaultConfigForUPSTypeTestCest
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
        $this->helperContainer->create("Magento\Tax\Test\Mftf\Helper\TaxHelpers");
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
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
		$I->comment("Collapse UPS tab and logout");
		$I->comment("Collapse UPS tab and logout");
		$I->click("#carriers_ups-head"); // stepKey: collapseTab
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
	 * @Features({"Ups"})
	 * @Stories({"UPS configuration", "UPS"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DefaultConfigForUPSTypeTest(AcceptanceTester $I)
	{
		$I->comment("Set shipping methods UPS type to default");
		$I->comment("Set shipping methods UPS type to default");
		$I->createEntity("setShippingMethodsUpsTypeToDefault", "test", "ShippingMethodsUpsTypeSetDefault", [], []); // stepKey: setShippingMethodsUpsTypeToDefault
		$I->comment("Navigate to Stores -> Configuration -> Sales -> Shipping Methods Page");
		$I->comment("Navigate to Stores -> Configuration -> Sales -> Shipping Methods Page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/carriers/"); // stepKey: navigateToAdminShippingMethodsPage
		$I->waitForPageLoad(30); // stepKey: waitPageToLoad
		$I->comment("Expand 'UPS' tab");
		$I->comment("Expand UPS tab");
		$I->conditionalClick("#carriers_ups-head", "#carriers_ups_type", false); // stepKey: expandTab
		$I->waitForElementVisible("#carriers_ups_type", 30); // stepKey: waitTabToExpand
		$I->comment("Assert that selected UPS type by default is 'United Parcel Service XML'");
		$I->comment("Check that selected UPS type by default is 'United Parcel Service XML'");
		$grabSelectedOptionText = $I->grabTextFrom("#carriers_ups_type option[selected]"); // stepKey: grabSelectedOptionText
		$I->assertEquals("United Parcel Service XML", ($grabSelectedOptionText)); // stepKey: assertDefaultUpsType
	}
}
