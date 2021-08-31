<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @group WYSIWYGDisabled
 * @group Widget
 * @Title("[NO TESTCASEID]: Admin should be able to set products as new so that they show up in the Catalog New Products List Widget")
 * @Description("Admin should be able to set products as new so that they show up in the Catalog New Products List Widget<h3>Test files</h3>app/code/Magento/Widget/Test/Mftf/Test/NewProductsListWidgetTest.xml<br>")
 */
class NewProductsListWidgetTestCest
{
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
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
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
	 * @Stories({"New products list widget"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function NewProductsListWidgetTest(AcceptanceTester $I)
	{
		$I->comment("Create a CMS page containing the New Products widget");
		$I->comment("Entering Action Group [amOnCmsList] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridAmOnCmsList
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnCmsList
		$I->comment("Exiting Action Group [amOnCmsList] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickAddNewPageButton] AdminClickAddNewPageOnPagesGridActionGroup");
		$I->click("#add"); // stepKey: clickAddNewPageClickAddNewPageButton
		$I->waitForPageLoad(30); // stepKey: clickAddNewPageClickAddNewPageButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickAddNewPageButton
		$I->comment("Exiting Action Group [clickAddNewPageButton] AdminClickAddNewPageOnPagesGridActionGroup");
		$I->comment("Entering Action Group [fillPageTitle] AdminCmsPageSetTitleActionGroup");
		$I->fillField("input[name=title]", "Test CMS Page" . msq("_newDefaultCmsPage")); // stepKey: fillNewTitleFillPageTitle
		$I->comment("Exiting Action Group [fillPageTitle] AdminCmsPageSetTitleActionGroup");
		$I->comment("Entering Action Group [expandContentSection] AdminExpandContentSectionActionGroup");
		$I->click("div[data-index=content]"); // stepKey: expandContentSectionExpandContentSection
		$I->waitForPageLoad(30); // stepKey: waitForContentSectionExpandContentSection
		$I->comment("Exiting Action Group [expandContentSection] AdminExpandContentSectionActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickInsertWidgetButton] AdminInsertCatalogNewProductListWidgetForCmsPageContentSectionActionGroup");
		$I->click(".action-add-widget"); // stepKey: clickInsertWidgetButtonClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: waitForSlideOutClickInsertWidgetButton
		$I->selectOption("#select_widget_type", "Catalog New Products List"); // stepKey: selectWidgetTypeClickInsertWidgetButton
		$I->waitForPageLoad(30); // stepKey: waitForWidgetOptionsClickInsertWidgetButton
		$I->selectOption("select[name='parameters[display_type]']", "New products"); // stepKey: selectDisplayTypeClickInsertWidgetButton
		$I->selectOption("[name='parameters[show_pager]']", "No"); // stepKey: selectDisplayPageControlClickInsertWidgetButton
		$I->fillField("[name='parameters[products_count]']", "100"); // stepKey: fillNumberOfProductsToDisplayClickInsertWidgetButton
		$I->selectOption("[name='parameters[template]']", "New Products Grid Template"); // stepKey: selectTemplateClickInsertWidgetButton
		$I->fillField("[name='parameters[cache_lifetime]']", ""); // stepKey: fillCacheLifetimeClickInsertWidgetButton
		$I->comment("Exiting Action Group [clickInsertWidgetButton] AdminInsertCatalogNewProductListWidgetForCmsPageContentSectionActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidget
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidget
		$I->comment("Exiting Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->comment("Entering Action Group [expandSeoSection] AdminExpandSeoSectionActionGroup");
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: expandSeoSectionExpandSeoSection
		$I->waitForPageLoad(30); // stepKey: expandSeoSectionExpandSeoSectionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSeoSectionExpandSeoSection
		$I->comment("Exiting Action Group [expandSeoSection] AdminExpandSeoSectionActionGroup");
		$I->comment("Entering Action Group [fillPageUrlKey] AdminCmsPageSetUrlActionGroup");
		$I->fillField("input[name=identifier]", "test-page-" . msq("_newDefaultCmsPage")); // stepKey: fillPageUrlKeyFillPageUrlKey
		$I->comment("Exiting Action Group [fillPageUrlKey] AdminCmsPageSetUrlActionGroup");
		$I->comment("Entering Action Group [clickSaveCmsPage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonClickSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonClickSaveCmsPageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonClickSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonClickSaveCmsPageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageClickSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageClickSaveCmsPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageClickSaveCmsPage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageClickSaveCmsPageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonClickSaveCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonClickSaveCmsPageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveCmsPage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageClickSaveCmsPage
		$I->comment("Exiting Action Group [clickSaveCmsPage] SaveCmsPageActionGroup");
	}
}
