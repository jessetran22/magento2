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
 * @Title("MAGETWO-89024: Admin should be able to configure the default layout for Category Page from System Configuration")
 * @Description("Admin should be able to configure the default layout for Category Page from System Configuration<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryTest/AdminConfigDefaultCategoryLayoutFromConfigurationSettingTest.xml<br>")
 * @TestCaseId("MAGETWO-89024")
 * @group category
 */
class AdminConfigDefaultCategoryLayoutFromConfigurationSettingTestCest
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
		$I->comment("Entering Action Group [sampleActionGroup] RestoreLayoutSetting");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPageSampleActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSampleActionGroup
		$I->conditionalClick("#web_default_layouts-head", "#web_default_layouts-head:not(.open)", true); // stepKey: expandDefaultLayoutsSampleActionGroup
		$I->selectOption("#web_default_layouts_default_category_layout", "No layout updates"); // stepKey: selectNoLayoutUpdates1SampleActionGroup
		$I->waitForElementVisible("#web_default_layouts_default_cms_layout", 30); // stepKey: waittForDefaultCMSLayoutSampleActionGroup
		$I->selectOption("#web_default_layouts_default_cms_layout", "1 column"); // stepKey: selectOneColumnSampleActionGroup
		$I->selectOption("#web_default_layouts_default_product_layout", "No layout updates"); // stepKey: selectNoLayoutUpdates2SampleActionGroup
		$I->click("#save"); // stepKey: clickSaveConfigSampleActionGroup
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigSampleActionGroupWaitForPageLoad
		$I->comment("Exiting Action Group [sampleActionGroup] RestoreLayoutSetting");
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
	public function AdminConfigDefaultCategoryLayoutFromConfigurationSettingTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToWebConfigurationPage] AdminOpenWebConfigurationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: openWebConfigurationPageNavigateToWebConfigurationPage
		$I->waitForPageLoad(30); // stepKey: waitPageToLoadNavigateToWebConfigurationPage
		$I->comment("Exiting Action Group [navigateToWebConfigurationPage] AdminOpenWebConfigurationPageActionGroup");
		$I->conditionalClick("#web_default_layouts-head", "#web_default_layouts-head:not(.open)", true); // stepKey: expandDefaultLayouts
		$I->waitForElementVisible("#web_default_layouts_default_category_layout", 30); // stepKey: waitForDefaultCategoryLayout
		$I->seeOptionIsSelected("#web_default_layouts_default_category_layout", "No layout updates"); // stepKey: seeNoLayoutUpdatesSelected
		$I->selectOption("#web_default_layouts_default_category_layout", "2 columns with right bar"); // stepKey: select2ColumnsLayout
		$I->click("#save"); // stepKey: clickSaveConfig
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigWaitForPageLoad
		$I->comment("Entering Action Group [navigateToNewCatalog] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToNewCatalog
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToNewCatalog
		$I->comment("Exiting Action Group [navigateToNewCatalog] AdminOpenCategoryPageActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait2
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryWaitForPageLoad
		$I->click("//strong[@class='admin__collapsible-title']//span[text()='Design']"); // stepKey: clickOnDesignTab
		$I->waitForElementVisible("select[name='page_layout']", 30); // stepKey: waitForLayoutDropDown
		$I->seeOptionIsSelected("select[name='page_layout']", "2 columns with right bar"); // stepKey: see2ColumnsSelected
	}
}
