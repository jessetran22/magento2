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
 * @Title("MAGETWO-89023: Admin should be able to configure a default layout for Product Page from System Configuration")
 * @Description("Admin should be able to configure a default layout for Product Page from System Configuration<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateSimpleProductTest/AdminConfigDefaultProductLayoutFromConfigurationSettingTest.xml<br>")
 * @TestCaseId("MAGETWO-89023")
 * @group product
 */
class AdminConfigDefaultProductLayoutFromConfigurationSettingTestCest
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
		$I->comment("Entering Action Group [navigateToWebConfigurationPage1] NavigateToDefaultLayoutsSettingActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPageNavigateToWebConfigurationPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToWebConfigurationPage1
		$I->conditionalClick("#web_default_layouts-head", "#web_default_layouts-head:not(.open)", true); // stepKey: expandDefaultLayoutsNavigateToWebConfigurationPage1
		$I->waitForElementVisible("#web_default_layouts_default_category_layout", 30); // stepKey: waittForDefaultCategoryLayoutNavigateToWebConfigurationPage1
		$I->comment("Exiting Action Group [navigateToWebConfigurationPage1] NavigateToDefaultLayoutsSettingActionGroup");
		$I->comment("Entering Action Group [sampleActionGroup] AdminSetProductLayoutSettingsActionGroup");
		$I->waitForElementVisible("#web_default_layouts_default_product_layout", 30); // stepKey: waittForDefaultProductLayoutSampleActionGroup
		$I->selectOption("#web_default_layouts_default_product_layout", "1 column"); // stepKey: selectLayoutSampleActionGroup
		$I->click("#save"); // stepKey: clickSaveConfigSampleActionGroup
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigSampleActionGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingSystemConfigurationSampleActionGroup
		$I->see("You saved the configuration."); // stepKey: seeSuccessMessageSampleActionGroup
		$I->comment("Exiting Action Group [sampleActionGroup] AdminSetProductLayoutSettingsActionGroup");
		$I->comment("Entering Action Group [flushCacheBeforeTestFinishes] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCacheBeforeTestFinishes = $I->magentoCLI("cache:flush", 60, "config"); // stepKey: flushSpecifiedCacheFlushCacheBeforeTestFinishes
		$I->comment($flushSpecifiedCacheFlushCacheBeforeTestFinishes);
		$I->comment("Exiting Action Group [flushCacheBeforeTestFinishes] CliCacheFlushActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Default layout configuration MAGETWO-88793"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigDefaultProductLayoutFromConfigurationSettingTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToWebConfigurationPage] NavigateToDefaultLayoutsSettingActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPageNavigateToWebConfigurationPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToWebConfigurationPage
		$I->conditionalClick("#web_default_layouts-head", "#web_default_layouts-head:not(.open)", true); // stepKey: expandDefaultLayoutsNavigateToWebConfigurationPage
		$I->waitForElementVisible("#web_default_layouts_default_category_layout", 30); // stepKey: waittForDefaultCategoryLayoutNavigateToWebConfigurationPage
		$I->comment("Exiting Action Group [navigateToWebConfigurationPage] NavigateToDefaultLayoutsSettingActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibilityr");
		$I->comment("Entering Action Group [select3ColumnsLayout] AdminSetProductLayoutSettingsActionGroup");
		$I->waitForElementVisible("#web_default_layouts_default_product_layout", 30); // stepKey: waittForDefaultProductLayoutSelect3ColumnsLayout
		$I->selectOption("#web_default_layouts_default_product_layout", "3 columns"); // stepKey: selectLayoutSelect3ColumnsLayout
		$I->click("#save"); // stepKey: clickSaveConfigSelect3ColumnsLayout
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigSelect3ColumnsLayoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingSystemConfigurationSelect3ColumnsLayout
		$I->see("You saved the configuration."); // stepKey: seeSuccessMessageSelect3ColumnsLayout
		$I->comment("Exiting Action Group [select3ColumnsLayout] AdminSetProductLayoutSettingsActionGroup");
		$I->comment("Entering Action Group [clickSaveConfig] CliCacheFlushActionGroup");
		$flushSpecifiedCacheClickSaveConfig = $I->magentoCLI("cache:flush", 60, "config"); // stepKey: flushSpecifiedCacheClickSaveConfig
		$I->comment($flushSpecifiedCacheClickSaveConfig);
		$I->comment("Exiting Action Group [clickSaveConfig] CliCacheFlushActionGroup");
		$I->comment("Entering Action Group [navigateToNewProduct] AdminOpenNewProductFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: openProductNewPageNavigateToNewProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadNavigateToNewProduct
		$I->comment("Exiting Action Group [navigateToNewProduct] AdminOpenNewProductFormPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickOnDesignTab] AdminExpandProductDesignSectionActionGroup");
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Design']"); // stepKey: clickDesignTabClickOnDesignTab
		$I->waitForPageLoad(30); // stepKey: waitForTabOpenClickOnDesignTab
		$I->comment("Exiting Action Group [clickOnDesignTab] AdminExpandProductDesignSectionActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->seeOptionIsSelected("select[name='product[page_layout]']", "3 columns"); // stepKey: see3ColumnsSelected
	}
}
