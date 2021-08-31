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
 * @Title("MAGETWO-81819: Admin should see TinyMCE is the native WYSIWYG on Product Page")
 * @Description("Admin should see TinyMCE is the native WYSIWYG on Product Page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/VerifyTinyMCEIsNativeWYSIWYGOnProductTest.xml<br>")
 * @TestCaseId("MAGETWO-81819")
 */
class VerifyTinyMCEIsNativeWYSIWYGOnProductTestCest
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
	 * @Stories({"MAGETWO-72114-TinyMCE v4.6 as a native WYSIWYG editor"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifyTinyMCEIsNativeWYSIWYGOnProductTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: navigateToNewProduct
		$I->waitForPageLoad(30); // stepKey: wait1
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillName
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillPrice
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillSKU
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillQuantity
		$I->scrollTo(".admin__field[data-index=qty] input"); // stepKey: scrollToQty
		$I->click("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Content']"); // stepKey: clickContentTab
		$I->waitForElementVisible("#editorproduct_form_description .tox-tinymce", 30); // stepKey: waitForDescription
		$I->seeElement("#editorproduct_form_description .tox-tinymce"); // stepKey: TinyMCEDescription
		$I->click("#editorproduct_form_description .tox-edit-area"); // stepKey: focusProductDescriptionWysiwyg
		$executeJSFillContent1 = $I->executeJS("tinyMCE.get('product_form_description').setContent('Hello World!');"); // stepKey: executeJSFillContent1
		$I->waitForElementVisible("#editorproduct_form_short_description .tox-tinymce", 30); // stepKey: waitForShortDescription
		$I->seeElement("#editorproduct_form_short_description .tox-tinymce"); // stepKey: TinyMCEShortDescription
		$I->click("#editorproduct_form_short_description .tox-edit-area"); // stepKey: focusProductShortDescriptionWysiwyg
		$executeJSFillContent2 = $I->executeJS("tinyMCE.get('product_form_short_description').setContent('Hello World! Short Content');"); // stepKey: executeJSFillContent2
		$I->scrollTo("#editorproduct_form_description .scalable.action-show-hide", 0, -150); // stepKey: scrollToDesShowHideBtn1
		$I->click("#editorproduct_form_description .scalable.action-show-hide"); // stepKey: clickShowHideBtn1
		$I->waitForElementVisible("#editorproduct_form_description .scalable.action-add-image.plugin", 30); // stepKey: waitForInsertImage1
		$I->see("Insert Image...", "#editorproduct_form_description .scalable.action-add-image.plugin"); // stepKey: seeInsertImage1
		$I->dontSee(".action-add-widget"); // stepKey: insertWidget1
		$I->dontSee(".scalable.add-variable.plugin"); // stepKey: insertVariable1
		$I->scrollTo("#editorproduct_form_short_description .scalable.action-show-hide", 0, -150); // stepKey: scrollToDesShowHideBtn2
		$I->click("#editorproduct_form_short_description .scalable.action-show-hide"); // stepKey: clickShowHideBtn2
		$I->waitForElementVisible("#editorproduct_form_short_description .scalable.action-add-image.plugin", 30); // stepKey: waitForInsertImage2
		$I->see("Insert Image...", "#editorproduct_form_short_description .scalable.action-add-image.plugin"); // stepKey: seeInsertImage2
		$I->dontSee(".action-add-widget"); // stepKey: insertWidget2
		$I->dontSee(".scalable.add-variable.plugin"); // stepKey: insertVariable2
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->comment("Go to storefront product page, assert product content");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: navigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->scrollTo(".stock.available"); // stepKey: scrollToStock
		$I->see("Hello World!", "#description .value"); // stepKey: assertProductDescription
		$I->see("Hello World! Short Content", "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescription
	}
}
