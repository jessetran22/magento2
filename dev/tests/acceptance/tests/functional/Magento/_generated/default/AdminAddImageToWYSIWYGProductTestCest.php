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
 * @Title("MC-25763: Admin should be able to add image to WYSIWYG Editor on Product Page")
 * @Description("Admin should be able to add image to WYSIWYG Editor on Product Page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminAddImageToWYSIWYGProductTest.xml<br>")
 * @TestCaseId("MC-25763")
 * @group catalog
 */
class AdminAddImageToWYSIWYGProductTestCest
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
	 * @Stories({"Default WYSIWYG toolbar configuration with Magento Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddImageToWYSIWYGProductTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: navigateToNewProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadProductCreatePage
		$I->comment("Entering Action Group [fillBasicProductInfo] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillBasicProductInfo
		$I->fillField(".admin__field[data-index=name] input", "testProductName" . msq("_defaultProduct")); // stepKey: fillProductNameFillBasicProductInfo
		$I->fillField(".admin__field[data-index=sku] input", "testSku" . msq("_defaultProduct")); // stepKey: fillProductSkuFillBasicProductInfo
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillBasicProductInfo
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillBasicProductInfo
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillBasicProductInfo
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillBasicProductInfoWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillBasicProductInfo
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillBasicProductInfo
		$I->comment("Exiting Action Group [fillBasicProductInfo] FillMainProductFormActionGroup");
		$I->click("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Content']"); // stepKey: clickContentTab
		$I->scrollTo("#editorproduct_form_description .scalable.action-show-hide", 0, -150); // stepKey: scrollToDescription
		$I->waitForElementVisible("#editorproduct_form_description .tox-tinymce", 30); // stepKey: waitForDescription
		$I->scrollTo("#editorproduct_form_description .scalable.action-show-hide", 0, -150); // stepKey: scrollToDescriptionAgain
		$I->click("#editorproduct_form_description button[title='Insert/edit image']"); // stepKey: clickInsertImageIcon1
		$I->waitForPageLoad(30); // stepKey: clickInsertImageIcon1WaitForPageLoad
		$I->click(".tox-browse-url"); // stepKey: clickBrowse1
		$I->waitForPageLoad(30); // stepKey: waitForBrowseModal
		$I->waitForElement("#cancel", 30); // stepKey: waitForCancelBtn1
		$I->see("Cancel", "#cancel"); // stepKey: seeCancelBtn1
		$I->see("Create Folder", "#new_folder"); // stepKey: seeCreateFolderBtn1
		$I->waitForPageLoad(30); // stepKey: seeCreateFolderBtn1WaitForPageLoad
		$I->dontSeeElement("#insert_files"); // stepKey: dontSeeAddSelectedBtn1
		$I->waitForPageLoad(30); // stepKey: dontSeeAddSelectedBtn1WaitForPageLoad
		$I->click("#new_folder"); // stepKey: createFolder1
		$I->waitForPageLoad(30); // stepKey: createFolder1WaitForPageLoad
		$I->waitForElement("input[data-role='promptField']", 30); // stepKey: waitForPopUp1
		$I->fillField("input[data-role='promptField']", "Test" . msq("ImageFolder")); // stepKey: fillFolderName1
		$I->click(".action-primary.action-accept"); // stepKey: acceptFolderName11
		$I->conditionalClick("#root > .jstree-icon", "//li[@id='root' and contains(@class,'jstree-closed')]", true); // stepKey: clickStorageRootArrowIfClosed
		$I->waitForPageLoad(30); // stepKey: waitForStorageRootLoadingMaskDisappear
		$I->conditionalClick("#d3lzaXd5Zw-- > .jstree-icon", "//li[@id='d3lzaXd5Zw--' and contains(@class,'jstree-closed')]", true); // stepKey: clickWysiwygArrowIfClosed
		$I->waitForText("Test" . msq("ImageFolder"), 30); // stepKey: waitForNewFolder1
		$I->click("Test" . msq("ImageFolder")); // stepKey: clickOnCreatedFolder1
		$I->waitForPageLoad(30); // stepKey: waitForLoading4
		$I->attachFile(".fileupload", "magento2.jpg"); // stepKey: uploadImage1
		$I->waitForPageLoad(30); // stepKey: waitForFileUpload1
		$I->waitForElementVisible("//small[text()='magento2.jpg']", 30); // stepKey: waitForUploadImage1
		$I->seeElement("//small[text()='magento2.jpg']/parent::*[@class='filecnt selected']"); // stepKey: seeImageSelected1
		$I->see("Delete Selected", "#delete_files"); // stepKey: seeDeleteBtn1
		$I->waitForPageLoad(30); // stepKey: seeDeleteBtn1WaitForPageLoad
		$I->click("#delete_files"); // stepKey: clickDeleteSelected1
		$I->waitForPageLoad(30); // stepKey: clickDeleteSelected1WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmDelete1
		$I->waitForPageLoad(60); // stepKey: waitForConfirmDelete1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDelete1
		$I->waitForPageLoad(60); // stepKey: confirmDelete1WaitForPageLoad
		$I->waitForElementNotVisible("//small[text()='magento2.jpg']", 30); // stepKey: waitForImageDeleted1
		$I->dontSeeElement("//small[text()='magento2.jpg']"); // stepKey: dontSeeImage1
		$I->dontSeeElement("#insert_files"); // stepKey: dontSeeAddSelectedBtn2
		$I->waitForPageLoad(30); // stepKey: dontSeeAddSelectedBtn2WaitForPageLoad
		$I->click("Test" . msq("ImageFolder")); // stepKey: selectCreatedFolder1
		$I->waitForPageLoad(30); // stepKey: waitForSelectFolder
		$I->attachFile(".fileupload", "magento2.jpg"); // stepKey: uploadImage2
		$I->waitForPageLoad(30); // stepKey: waitForFileUpload2
		$I->waitForElementVisible("//small[text()='magento2.jpg']", 30); // stepKey: waitForUploadImage2
		$I->click("#insert_files"); // stepKey: clickInsertBtn1
		$I->waitForPageLoad(30); // stepKey: clickInsertBtn1WaitForPageLoad
		$I->waitForElementVisible("//label[text()='Alternative description']/parent::div//input", 30); // stepKey: waitForImageDescriptionButton1
		$I->fillField("//label[text()='Alternative description']/parent::div//input", "Image content. Yeah."); // stepKey: fillImageDescription1
		$I->fillField("//label[text()='Height']/parent::div//input", "1000"); // stepKey: fillImageHeight1
		$I->click(".tox-dialog__footer button[title='Save']"); // stepKey: clickOkBtn1
		$I->scrollTo("#editorproduct_form_short_description .scalable.action-show-hide", 0, -150); // stepKey: scrollToTinyMCE
		$I->click("#editorproduct_form_short_description button[title='Insert/edit image']"); // stepKey: clickInsertImageIcon2
		$I->waitForPageLoad(30); // stepKey: clickInsertImageIcon2WaitForPageLoad
		$I->click(".tox-browse-url"); // stepKey: clickBrowse2
		$I->waitForPageLoad(30); // stepKey: waitForLoading13
		$I->waitForElementVisible("#cancel", 30); // stepKey: waitForCancelButton2
		$I->see("Cancel", "#cancel"); // stepKey: seeCancelBtn2
		$I->waitForElementVisible("#new_folder", 30); // stepKey: waitForCreateFolderBtn2
		$I->waitForPageLoad(30); // stepKey: waitForCreateFolderBtn2WaitForPageLoad
		$I->see("Create Folder", "#new_folder"); // stepKey: seeCreateFolderBtn2
		$I->waitForPageLoad(30); // stepKey: seeCreateFolderBtn2WaitForPageLoad
		$I->see("Storage Root", "div[data-role='tree']"); // stepKey: seeFolderContainer
		$I->click("Storage Root"); // stepKey: clickOnRootFolder
		$I->waitForPageLoad(30); // stepKey: waitForLoading15
		$I->dontSeeElement("#insert_files"); // stepKey: dontSeeAddSelectedBtn3
		$I->waitForPageLoad(30); // stepKey: dontSeeAddSelectedBtn3WaitForPageLoad
		$I->attachFile(".fileupload", "magento3.jpg"); // stepKey: uploadImage3
		$I->waitForPageLoad(30); // stepKey: waitForFileUpload3
		$I->waitForElementVisible("//small[text()='magento3.jpg']", 30); // stepKey: waitForUploadImage3
		$I->waitForElement("#delete_files", 30); // stepKey: waitForDeletebtn
		$I->waitForPageLoad(30); // stepKey: waitForDeletebtnWaitForPageLoad
		$I->see("Delete Selected", "#delete_files"); // stepKey: seeDeleteBtn2
		$I->waitForPageLoad(30); // stepKey: seeDeleteBtn2WaitForPageLoad
		$I->click("#delete_files"); // stepKey: clickDeleteSelected2
		$I->waitForPageLoad(30); // stepKey: clickDeleteSelected2WaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirm3
		$I->waitForPageLoad(60); // stepKey: waitForConfirm3WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDelete2
		$I->waitForPageLoad(60); // stepKey: confirmDelete2WaitForPageLoad
		$I->dontSeeElement("#insert_files"); // stepKey: dontSeeAddSelectedBtn4
		$I->waitForPageLoad(30); // stepKey: dontSeeAddSelectedBtn4WaitForPageLoad
		$I->click("Test" . msq("ImageFolder")); // stepKey: selectCreatedFolder2
		$I->waitForPageLoad(30); // stepKey: waitForSelectFolder2
		$I->attachFile(".fileupload", "magento3.jpg"); // stepKey: uploadImage4
		$I->waitForPageLoad(30); // stepKey: waitForFileUpload4
		$I->waitForElementVisible("//small[text()='magento3.jpg']", 30); // stepKey: waitForUploadImage4
		$I->click("#insert_files"); // stepKey: clickInsertBtn
		$I->waitForPageLoad(30); // stepKey: clickInsertBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoading11
		$I->waitForElementVisible(".tox-dialog__footer button[title='Save']", 30); // stepKey: waitForOkBtn2
		$I->fillField("//label[text()='Alternative description']/parent::div//input", "Image content. Yeah."); // stepKey: fillImageDescription2
		$I->fillField("//label[text()='Height']/parent::div//input", "1000"); // stepKey: fillImageHeight2
		$I->click(".tox-dialog__footer button[title='Save']"); // stepKey: clickOkBtn2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad6
		$I->comment("Entering Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: saveProductSaveProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingSaveProduct
		$I->comment("Exiting Action Group [saveProduct] AdminProductFormSaveActionGroup");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: navigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad7
		$I->seeElement(".product.attribute.description>div>p>img"); // stepKey: assertMediaDescription
		$I->seeElementInDOM("//img[contains(@src,'magento3')]"); // stepKey: assertMediaSource3
		$I->seeElementInDOM("//img[contains(@src,'magento2')]"); // stepKey: assertMediaSource1
	}
}
