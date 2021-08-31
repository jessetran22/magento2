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
 * @Title("[NO TESTCASEID]: Admin content widgets display on specific entities test")
 * @Description("Admin should be able to select specific entities for widgets<h3>Test files</h3>app/code/Magento/Widget/Test/Mftf/Test/AdminContentWidgetsDisplayOnSpecificEntitiesTest.xml<br>")
 * @group widget
 */
class AdminContentWidgetsDisplayOnSpecificEntitiesTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
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
	 * @Features({"Widget"})
	 * @Stories({"Widget parameter configuration"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminContentWidgetsDisplayOnSpecificEntitiesTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/widget_instance/new/"); // stepKey: createWidgetPage
		$I->comment("Entering Action Group [fillForm] AdminCreateSpecificEntityWidgetActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/widget_instance/new/"); // stepKey: amOnAdminNewWidgetPageFillForm
		$I->selectOption("#code", "Catalog Category Link"); // stepKey: setWidgetTypeFillForm
		$I->selectOption("#theme_id", "Magento Luma"); // stepKey: setWidgetDesignThemeFillForm
		$I->click("#continue_button"); // stepKey: clickContinueFillForm
		$I->waitForPageLoad(30); // stepKey: clickContinueFillFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForContinueFillForm
		$I->waitForElementVisible("#title", 30); // stepKey: waitForTitleFillForm
		$I->fillField("#title", "TestCategoryLinkWidgetOnSpecifiedCategory" . msq("CatalogCategoryLinkSpecifiedCategory")); // stepKey: fillTitleFillForm
		$I->selectOption("#store_ids", "All Store Views"); // stepKey: setWidgetStoreIdsFillForm
		$I->click(".action-default.scalable.action-add"); // stepKey: clickAddLayoutUpdateFillForm
		$I->waitForElementVisible("#widget_instance[0][page_group]", 30); // stepKey: waitForLayoutUpdateFillForm
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->comment("BIC workaround");
		$I->selectOption("#widget_instance[0][page_group]", "Anchor Categories"); // stepKey: setDisplayOnFillForm
		$I->waitForPageLoad(30); // stepKey: waitForLoadFillForm
		$I->selectOption("select[name='widget_instance[0][anchor_categories][block]']", "Main Content Area"); // stepKey: setContainerFillForm
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFillForm
		$I->seeElement("#specific_anchor_categories_0"); // stepKey: seeSpecificEntityRadioFillForm
		$I->click("#specific_anchor_categories_0"); // stepKey: clickSpecificEntityRadioFillForm
		$I->seeElement("#anchor_categories_ids_0 .widget-option-chooser"); // stepKey: seeChooserTriggerFillForm
		$I->click("#anchor_categories_ids_0 .widget-option-chooser"); // stepKey: clickChooserTriggerFillForm
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxCategoryLoadFillForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillForm
		$I->click("#widget_instace_tabs_properties_section"); // stepKey: clickWidgetOptionsFillForm
		$I->waitForPageLoad(30); // stepKey: waitForWidgetOptionsFillForm
		$I->comment("Exiting Action Group [fillForm] AdminCreateSpecificEntityWidgetActionGroup");
	}
}
