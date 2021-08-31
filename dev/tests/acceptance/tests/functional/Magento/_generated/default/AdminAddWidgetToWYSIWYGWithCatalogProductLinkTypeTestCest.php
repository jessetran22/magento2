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
 * @group Cms
 * @Title("MAGETWO-83788: Admin should be able to create a CMS page with widget type: Catalog product link")
 * @Description("Admin should be able to create a CMS page with widget type: Catalog product link<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminAddWidgetToWYSIWYGWithCatalogProductLinkTypeTest.xml<br>")
 * @TestCaseId("MAGETWO-83788")
 */
class AdminAddWidgetToWYSIWYGWithCatalogProductLinkTypeTestCest
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
		$I->createEntity("createPreReqCategory", "hook", "_defaultCategory", [], []); // stepKey: createPreReqCategory
		$I->createEntity("createPreReqProduct", "hook", "_defaultProduct", ["createPreReqCategory"], []); // stepKey: createPreReqProduct
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Entering Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$enableWYSIWYGEnableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled enabled", 60); // stepKey: enableWYSIWYGEnableWYSIWYG
		$I->comment($enableWYSIWYGEnableWYSIWYG);
		$I->comment("Exiting Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$I->comment("Entering Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
		$enableTinyMCEEnableTinyMCE = $I->magentoCLI("config:set cms/wysiwyg/editor mage/adminhtml/wysiwyg/tiny_mce/tinymce5Adapter", 60); // stepKey: enableTinyMCEEnableTinyMCE
		$I->comment($enableTinyMCEEnableTinyMCE);
		$I->comment("Exiting Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createPreReqCategory", "hook"); // stepKey: deletePreReqCatalog
		$I->deleteEntity("createPreReqProduct", "hook"); // stepKey: deletePreReqProduct
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$enableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 1", 60); // stepKey: enableGenerateUrlRewrite
		$I->comment($enableGenerateUrlRewrite);
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
	 * @Features({"Cms"})
	 * @Stories({"MAGETWO-42156-Widgets in WYSIWYG"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddWidgetToWYSIWYGWithCatalogProductLinkTypeTest(AcceptanceTester $I)
	{
		$I->comment("Main test");
		$I->comment("Entering Action Group [navigateToPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageNavigateToPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadNavigateToPage
		$I->comment("Exiting Action Group [navigateToPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->fillField("input[name=title]", "Test CMS Page"); // stepKey: fillFieldTitle
		$I->click("div[data-index=content]"); // stepKey: clickContentTab
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE
		$executeJSFillContent = $I->executeJS("tinyMCE.activeEditor.setContent('Hello CMS Page!');"); // stepKey: executeJSFillContent
		$I->seeElement("button[aria-label='Insert Widget']"); // stepKey: seeWidgetIcon
		$I->waitForPageLoad(30); // stepKey: seeWidgetIconWaitForPageLoad
		$I->click("button[aria-label='Insert Widget']"); // stepKey: clickInsertWidgetIcon
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetIconWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->see("Inserting a widget does not create a widget instance."); // stepKey: seeMessage
		$I->waitForPageLoad(30); // stepKey: wait3
		$I->comment("see Insert Widget button disabled");
		$I->see("Insert Widget", "//button[@id='insert_button' and contains(@class,'disabled')]"); // stepKey: seeInsertWidgetDisabled
		$I->comment("see Cancel button enabled");
		$I->see("Cancel", "//button[@id='reset' and not(contains(@class,'disabled'))]"); // stepKey: seeCancelBtnEnabled
		$I->comment("Select \"Widget Type\"");
		$I->selectOption("#select_widget_type", "Catalog Product Link"); // stepKey: selectCatalogProductLink
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappear
		$I->see("Insert Widget", "//button[@id='insert_button' and not(contains(@class,'disabled'))]"); // stepKey: seeInsertWidgetEnabled
		$I->selectOption("select[name='parameters[template]']", "Product Link Block Template"); // stepKey: selectTemplate
		$I->click(".btn-chooser"); // stepKey: clickSelectPageBtn
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait4
		$I->click("img.x-tree-elbow-end-plus"); // stepKey: expandRootCategory
		$I->waitForElementVisible(" //span[contains(text(),'" . $I->retrieveEntityField('createPreReqCategory', 'name', 'test') . "')]", 30); // stepKey: expandWait
		$I->click(" //span[contains(text(),'" . $I->retrieveEntityField('createPreReqCategory', 'name', 'test') . "')]"); // stepKey: selectPreCategory
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitLoadingMask
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createPreReqProduct', 'name', 'test') . "')]"); // stepKey: selectPreProduct
		$I->waitForElementNotVisible("//h1[contains(text(),'Select Product')]", 30); // stepKey: waitForSlideOutCloses
		$I->comment("Entering Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->click("#insert_button"); // stepKey: clickInsertWidgetButtonClickInsertWidget
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetButtonClickInsertWidgetWaitForPageLoad
		$I->waitForElementNotVisible("//h1[contains(text(),'Insert Widget')]", 30); // stepKey: waitForWidgetPopupDisappearClickInsertWidget
		$I->comment("Exiting Action Group [clickInsertWidget] AdminClickInsertWidgetActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->scrollTo("div[data-index=search_engine_optimisation]"); // stepKey: scrollToSearchEngineTab
		$I->waitForPageLoad(30); // stepKey: scrollToSearchEngineTabWaitForPageLoad
		$I->click("div[data-index=search_engine_optimisation]"); // stepKey: clickExpandSearchEngineOptimisation
		$I->waitForPageLoad(30); // stepKey: clickExpandSearchEngineOptimisationWaitForPageLoad
		$I->fillField("input[name=identifier]", "test-page-" . msq("_defaultCmsPage")); // stepKey: fillFieldUrlKey
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickSavePage] SaveCmsPageActionGroup");
		$I->waitForElementVisible("//button[@data-ui-id='save-button-dropdown']", 30); // stepKey: waitForSplitButtonClickSavePage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonClickSavePageWaitForPageLoad
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandSplitButtonClickSavePage
		$I->waitForPageLoad(10); // stepKey: expandSplitButtonClickSavePageWaitForPageLoad
		$I->waitForElementVisible("#save_and_close", 30); // stepKey: waitForSaveCmsPageClickSavePage
		$I->waitForPageLoad(10); // stepKey: waitForSaveCmsPageClickSavePageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSaveCmsPageClickSavePage
		$I->waitForPageLoad(10); // stepKey: clickSaveCmsPageClickSavePageWaitForPageLoad
		$I->waitForElementVisible("#add", 1); // stepKey: waitForCmsPageSaveButtonClickSavePage
		$I->waitForPageLoad(30); // stepKey: waitForCmsPageSaveButtonClickSavePageWaitForPageLoad
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSavePage
		$I->see("You saved the page.", ".message-success"); // stepKey: assertSavePageSuccessMessageClickSavePage
		$I->comment("Exiting Action Group [clickSavePage] SaveCmsPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->amOnPage("test-page-" . msq("_defaultCmsPage")); // stepKey: amOnPageTestPage
		$I->waitForPageLoad(30); // stepKey: wait7
		$I->comment("see widget on Storefront");
		$I->see("Hello CMS Page!"); // stepKey: seeContent
		$I->see($I->retrieveEntityField('createPreReqProduct', 'name', 'test')); // stepKey: seeProductLink
		$disableGenerateUrlRewrite = $I->magentoCLI("config:set catalog/seo/generate_category_product_rewrites 0", 60); // stepKey: disableGenerateUrlRewrite
		$I->comment($disableGenerateUrlRewrite);
		$I->amOnPage("test-page-" . msq("_defaultCmsPage")); // stepKey: amOnPageTestPage2
		$I->waitForPageLoad(30); // stepKey: wait8
		$I->comment("see widget on Storefront");
		$dataHref = $I->grabAttributeFrom(".widget a", "href"); // stepKey: dataHref
		$I->assertRegExp("|" . $I->retrieveEntityField('createPreReqCategory', 'name', 'test') . "/" . $I->retrieveEntityField('createPreReqProduct', 'name', 'test') . ".html|i", $dataHref); // stepKey: seeProductLinkInCategory
	}
}
