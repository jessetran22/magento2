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
 * @group LayerNavigation
 * @Title("MC-12604: Admin should be able to uncheck Default Value checkbox for dependent field")
 * @Description("Admin should be able to uncheck Default Value checkbox for dependent field<h3>Test files</h3>app/code/Magento/LayeredNavigation/Test/Mftf/Test/AdminSpecifyLayerNavigationConfigurationTest.xml<br>")
 * @TestCaseId("MC-12604")
 */
class AdminSpecifyLayerNavigationConfigurationTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
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
	 * @Features({"LayeredNavigation"})
	 * @Stories({"Magento_LayeredNavigation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSpecifyLayerNavigationConfigurationTest(AcceptanceTester $I)
	{
		$I->comment("Configure Layered Navigation in Stores -> Configuration -> Catalog -> Layered Navigation");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/catalog/"); // stepKey: navigateToConfigurationPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->conditionalClick("#catalog_layered_navigation-head", "#catalog_layered_navigation-head:not(.open)", true); // stepKey: expandLayeredNavigationTab
		$I->waitForElementVisible("#catalog_layered_navigation_price_range_calculation_inherit", 30); // stepKey: waitForUseSystemValueVisible
		$I->comment("Display Product Count = yes; Price Navigation Step Calculation = Manual; Default Price Navigation Step = 102");
		$I->uncheckOption("#catalog_layered_navigation_price_range_calculation_inherit"); // stepKey: uncheckUseSystemValue
		$I->selectOption("#catalog_layered_navigation_price_range_calculation", "Manual"); // stepKey: selectOption
		$I->uncheckOption("#catalog_layered_navigation_price_range_step_inherit"); // stepKey: uncheckUseStepSystemValue
		$I->fillField("#catalog_layered_navigation_price_range_step", "102"); // stepKey: fillPriceNavStep
		$I->click("#save"); // stepKey: saveConfig
		$I->waitForPageLoad(30); // stepKey: saveConfigWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingSystemConfiguration
		$I->waitForElementVisible("#catalog_layered_navigation", 30); // stepKey: waitForLayeredNav
		$I->scrollTo("#catalog_layered_navigation", 0, -80); // stepKey: scrollToLayeredNavigation
		$I->seeInField("#catalog_layered_navigation_price_range_step", "102"); // stepKey: seeThatValueWasSaved
		$I->comment("It is possible uncheck Use Default checkbox");
		$I->checkOption("#catalog_layered_navigation_price_range_calculation_inherit"); // stepKey: setStepCalculationToDefaultValue
		$I->checkOption("#catalog_layered_navigation_price_range_step_inherit"); // stepKey: setPriceNavToDefaultValue
		$I->click("#save"); // stepKey: saveConfiguration
		$I->waitForPageLoad(30); // stepKey: saveConfigurationWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveSystemConfiguration
	}
}
