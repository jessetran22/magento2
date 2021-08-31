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
 * @group Catalog
 * @Title("MAGETWO-82551: Admin should see TinyMCE is the native WYSIWYG on Catalog Page")
 * @Description("Admin should see TinyMCE is the native WYSIWYG on Catalog Page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/VerifyTinyMCEIsNativeWYSIWYGOnCatalogTest.xml<br>")
 * @TestCaseId("MAGETWO-82551")
 */
class VerifyTinyMCEIsNativeWYSIWYGOnCatalogTestCest
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
		$I->comment("Entering Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginGetFromGeneralFile
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginGetFromGeneralFile
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginGetFromGeneralFile
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginGetFromGeneralFile
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginGetFromGeneralFileWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginGetFromGeneralFile
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginGetFromGeneralFile
		$I->comment("Exiting Action Group [loginGetFromGeneralFile] AdminLoginActionGroup");
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
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
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
	 * @Stories({"MAGETWO-72137-Apply new WYSIWYG on Categories Page"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifyTinyMCEIsNativeWYSIWYGOnCatalogTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewCatalog] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToNewCatalog
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToNewCatalog
		$I->comment("Exiting Action Group [navigateToNewCatalog] AdminOpenCategoryPageActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait2
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryWaitForPageLoad
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: enterCategoryName
		$I->click("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Content']"); // stepKey: clickContentTab
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE
		$I->seeElement(".scalable.action-show-hide"); // stepKey: seeShowHideBtn
		$I->comment("Entering Action Group [verifyTinyMCE] VerifyTinyMCEActionGroup");
		$I->seeElement("button[title='Blocks']"); // stepKey: assertInfo2VerifyTinyMCE
		$I->seeElement("button[title='Bold']"); // stepKey: assertInfo3VerifyTinyMCE
		$I->seeElement("button[title='Italic']"); // stepKey: assertInfo4VerifyTinyMCE
		$I->seeElement("button[title='Underline']"); // stepKey: assertInfo5VerifyTinyMCE
		$I->seeElement("button[title='Align left']"); // stepKey: assertInfo6VerifyTinyMCE
		$I->seeElement("button[title='Align center']"); // stepKey: assertInfo7VerifyTinyMCE
		$I->seeElement("button[title='Align right']"); // stepKey: assertInfo8VerifyTinyMCE
		$I->seeElement("div[title='Numbered list']"); // stepKey: assertInfo9VerifyTinyMCE
		$I->seeElement("div[title='Bullet list']"); // stepKey: assertInfo10VerifyTinyMCE
		$I->seeElement("button[title='Insert/edit link']"); // stepKey: assertInfo11VerifyTinyMCE
		$I->seeElement("button[title='Insert/edit image']"); // stepKey: assertInf12VerifyTinyMCE
		$I->waitForPageLoad(30); // stepKey: assertInf12VerifyTinyMCEWaitForPageLoad
		$I->seeElement("button[title='Table']"); // stepKey: assertInfo13VerifyTinyMCE
		$I->seeElement("button[title='Special character']"); // stepKey: assertInfo14VerifyTinyMCE
		$I->comment("Exiting Action Group [verifyTinyMCE] VerifyTinyMCEActionGroup");
		$executeJSFillContent = $I->executeJS("tinyMCE.get('category_form_description').setContent('Hello World!');"); // stepKey: executeJSFillContent
		$I->click(".scalable.action-show-hide"); // stepKey: clickShowHideBtn
		$I->waitForElementVisible(".scalable.action-add-image.plugin", 30); // stepKey: waitForInsertImage
		$I->seeElement(".scalable.action-add-image.plugin"); // stepKey: insertImage
		$I->dontSee(".action-add-widget"); // stepKey: insertWidget
		$I->dontSee(".scalable.add-variable.plugin"); // stepKey: insertVariable
		$I->comment("Entering Action Group [saveCatalog] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCatalog
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCatalogWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCatalog
		$I->comment("Exiting Action Group [saveCatalog] AdminSaveCategoryActionGroup");
		$I->comment("Go to storefront product page, assert product content");
		$I->amOnPage("/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: goToCategoryFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->waitForElementVisible("//div[@class='category-description']//p", 30); // stepKey: waitForDesVisible
		$I->see("Hello World!", "//div[@class='category-description']//p"); // stepKey: assertCatalogDescription
	}
}
