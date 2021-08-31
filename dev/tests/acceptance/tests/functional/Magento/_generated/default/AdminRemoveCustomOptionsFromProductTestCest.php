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
 * @Title("MC-11512: Remove custom options from product")
 * @Description("Remove custom options from product<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminRemoveCustomOptionsFromProductTest.xml<br>")
 * @TestCaseId("MC-11512")
 * @group catalog
 */
class AdminRemoveCustomOptionsFromProductTestCest
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
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->updateEntity("createProduct", "hook", "ProductWithTextFieldAndAreaAndFileOptions",["createProduct"]); // stepKey: updateProductWithOptions
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProductWithOptions
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearProductFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductFilter] ClearFiltersAdminDataGridActionGroup");
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
	 * @Stories({"Create product with custom options"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminRemoveCustomOptionsFromProductTest(AcceptanceTester $I)
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
		$I->comment("Edit Simple Product");
		$I->comment("Entering Action Group [goToProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductGoToProduct
		$I->comment("Exiting Action Group [goToProduct] AdminProductPageOpenByIdActionGroup");
		$I->comment("See 3 options are present");
		$I->comment("Entering Action Group [assertCustomOptionsField] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertCustomOptionsField
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertCustomOptionsFieldWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertCustomOptionsField
		$I->seeElement("//span[text()='OptionField']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertCustomOptionVisibleAssertCustomOptionsField
		$I->comment("Exiting Action Group [assertCustomOptionsField] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->comment("Entering Action Group [assertCustomOptionsArea] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertCustomOptionsArea
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertCustomOptionsAreaWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertCustomOptionsArea
		$I->seeElement("//span[text()='OptionArea']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertCustomOptionVisibleAssertCustomOptionsArea
		$I->comment("Exiting Action Group [assertCustomOptionsArea] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->comment("Entering Action Group [assertCustomOptionsFile] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertCustomOptionsFile
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertCustomOptionsFileWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertCustomOptionsFile
		$I->seeElement("//span[text()='OptionFile']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertCustomOptionVisibleAssertCustomOptionsFile
		$I->comment("Exiting Action Group [assertCustomOptionsFile] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->comment("Click delete \"Area\" and \"File\" options");
		$I->comment("Entering Action Group [deleteCustomOptionArea] AdminDeleteProductCustomOptionActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabDeleteCustomOptionArea
		$I->waitForPageLoad(30); // stepKey: expandContentTabDeleteCustomOptionAreaWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedDeleteCustomOptionArea
		$I->click("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(., 'OptionArea')]/parent::div/parent::div//button[@class='action-delete']"); // stepKey: clickDeleteCustomOptionDeleteCustomOptionArea
		$I->waitForPageLoad(30); // stepKey: clickDeleteCustomOptionDeleteCustomOptionAreaWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCustomOptionArea] AdminDeleteProductCustomOptionActionGroup");
		$I->comment("Entering Action Group [deleteCustomOptionFile] AdminDeleteProductCustomOptionActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabDeleteCustomOptionFile
		$I->waitForPageLoad(30); // stepKey: expandContentTabDeleteCustomOptionFileWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedDeleteCustomOptionFile
		$I->click("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(., 'OptionFile')]/parent::div/parent::div//button[@class='action-delete']"); // stepKey: clickDeleteCustomOptionDeleteCustomOptionFile
		$I->waitForPageLoad(30); // stepKey: clickDeleteCustomOptionDeleteCustomOptionFileWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCustomOptionFile] AdminDeleteProductCustomOptionActionGroup");
		$I->comment("Entering Action Group [assertVisibleCustomOptionField] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertVisibleCustomOptionField
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertVisibleCustomOptionFieldWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertVisibleCustomOptionField
		$I->seeElement("//span[text()='OptionField']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertCustomOptionVisibleAssertVisibleCustomOptionField
		$I->comment("Exiting Action Group [assertVisibleCustomOptionField] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("See only \"Field option\" left Also we shouldn't see any other options");
		$I->comment("Entering Action Group [assertVisibleSecondCustomOptionField] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertVisibleSecondCustomOptionField
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertVisibleSecondCustomOptionFieldWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertVisibleSecondCustomOptionField
		$I->seeElement("//span[text()='OptionField']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertCustomOptionVisibleAssertVisibleSecondCustomOptionField
		$I->comment("Exiting Action Group [assertVisibleSecondCustomOptionField] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->comment("Entering Action Group [assertNoCustomOptionsFile] AdminAssertProductHasNoCustomOptionActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertNoCustomOptionsFile
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertNoCustomOptionsFileWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertNoCustomOptionsFile
		$I->dontSeeElement("//span[text()='fourth option" . msq("ProductOptionFileSecond") . "']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertNoCustomOptionAssertNoCustomOptionsFile
		$I->comment("Exiting Action Group [assertNoCustomOptionsFile] AdminAssertProductHasNoCustomOptionActionGroup");
		$I->comment("Entering Action Group [assertNoCustomOptionsField] AdminAssertProductHasNoCustomOptionActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertNoCustomOptionsField
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertNoCustomOptionsFieldWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertNoCustomOptionsField
		$I->dontSeeElement("//span[text()='fifth option" . msq("ProductOptionFieldSecond") . "']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertNoCustomOptionAssertNoCustomOptionsField
		$I->comment("Exiting Action Group [assertNoCustomOptionsField] AdminAssertProductHasNoCustomOptionActionGroup");
		$I->comment("Click Add option \"File\"");
		$I->comment("Entering Action Group [createAddOptionFile] AddProductCustomOptionFileActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "button[data-index='button_add']", false); // stepKey: openCustomOptionSectionCreateAddOptionFile
		$I->waitForPageLoad(30); // stepKey: openCustomOptionSectionCreateAddOptionFileWaitForPageLoad
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionCreateAddOptionFile
		$I->waitForPageLoad(30); // stepKey: clickAddOptionCreateAddOptionFileWaitForPageLoad
		$I->waitForElementVisible("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", 30); // stepKey: waitForOptionCreateAddOptionFile
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "fourth option" . msq("ProductOptionFileSecond")); // stepKey: fillTitleCreateAddOptionFile
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: openTypeSelectCreateAddOptionFile
		$I->click("//*[@data-index='custom_options']//label[text()='File'][ancestor::*[contains(@class, '_active')]]"); // stepKey: selectTypeFileCreateAddOptionFile
		$I->waitForElementVisible("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'fourth option" . msq("ProductOptionFileSecond") . "')]/ancestor::tr//*[@data-index='price']//input", 30); // stepKey: waitForElementsCreateAddOptionFile
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'fourth option" . msq("ProductOptionFileSecond") . "')]/ancestor::tr//*[@data-index='price']//input", "9.99"); // stepKey: fillPriceCreateAddOptionFile
		$I->selectOption("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'fourth option" . msq("ProductOptionFileSecond") . "')]/ancestor::tr//*[@data-index='price_type']//select", "fixed"); // stepKey: selectPriceTypeCreateAddOptionFile
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'fourth option" . msq("ProductOptionFileSecond") . "')]/ancestor::tr//*[@data-index='file_extension']//input", "png, jpg, gif"); // stepKey: fillCompatibleExtensionsCreateAddOptionFile
		$I->comment("Exiting Action Group [createAddOptionFile] AddProductCustomOptionFileActionGroup");
		$I->comment("Click Add option \"Field\"");
		$I->comment("Entering Action Group [createCustomOptionField] AddProductCustomOptionFieldActionGroup");
		$I->scrollTo("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']"); // stepKey: scrollToAddButtonOptionCreateCustomOptionField
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "button[data-index='button_add']", false); // stepKey: openCustomOptionSectionCreateCustomOptionField
		$I->waitForPageLoad(30); // stepKey: openCustomOptionSectionCreateCustomOptionFieldWaitForPageLoad
		$I->click("button[data-index='button_add']"); // stepKey: clickAddOptionCreateCustomOptionField
		$I->waitForPageLoad(30); // stepKey: clickAddOptionCreateCustomOptionFieldWaitForPageLoad
		$I->waitForElementVisible("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", 30); // stepKey: waitForOptionCreateCustomOptionField
		$I->fillField("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, '_required')]//input", "fifth option" . msq("ProductOptionFieldSecond")); // stepKey: fillTitleCreateCustomOptionField
		$I->click("//*[@data-index='custom_options']//*[@data-index='options']/tbody/tr[last()]//*[contains(@class, 'admin__action-multiselect-text')]"); // stepKey: openTypeSelectCreateCustomOptionField
		$I->click("//*[@data-index='custom_options']//label[text()='Field'][ancestor::*[contains(@class, '_active')]]"); // stepKey: selectTypeFileCreateCustomOptionField
		$I->waitForElementVisible("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'fifth option" . msq("ProductOptionFieldSecond") . "')]/ancestor::tr//*[@data-index='price']//input", 30); // stepKey: waitForElementsCreateCustomOptionField
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'fifth option" . msq("ProductOptionFieldSecond") . "')]/ancestor::tr//*[@data-index='price']//input", "10"); // stepKey: fillPriceCreateCustomOptionField
		$I->selectOption("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'fifth option" . msq("ProductOptionFieldSecond") . "')]/ancestor::tr//*[@data-index='price_type']//select", "fixed"); // stepKey: selectPriceTypeCreateCustomOptionField
		$I->fillField("//*[@data-index='options']//*[@data-role='collapsible-title' and contains(., 'fifth option" . msq("ProductOptionFieldSecond") . "')]/ancestor::tr//*[@data-index='sku']//input", "fifth option" . msq("ProductOptionFieldSecond")); // stepKey: fillSkuCreateCustomOptionField
		$I->comment("Exiting Action Group [createCustomOptionField] AddProductCustomOptionFieldActionGroup");
		$I->comment("Entering Action Group [saveProductWithNewlyAddedOptions] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductWithNewlyAddedOptions
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductWithNewlyAddedOptions
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWithNewlyAddedOptionsWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductWithNewlyAddedOptions
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWithNewlyAddedOptionsWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductWithNewlyAddedOptions
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductWithNewlyAddedOptions
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductWithNewlyAddedOptions
		$I->comment("Exiting Action Group [saveProductWithNewlyAddedOptions] SaveProductFormActionGroup");
		$I->comment("See 3 options are present");
		$I->comment("Entering Action Group [assertPresentCustomOptionField] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertPresentCustomOptionField
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertPresentCustomOptionFieldWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertPresentCustomOptionField
		$I->seeElement("//span[text()='OptionField']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertCustomOptionVisibleAssertPresentCustomOptionField
		$I->comment("Exiting Action Group [assertPresentCustomOptionField] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->comment("Entering Action Group [assertPresenceOfFileOption] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertPresenceOfFileOption
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertPresenceOfFileOptionWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertPresenceOfFileOption
		$I->seeElement("//span[text()='fourth option" . msq("ProductOptionFileSecond") . "']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertCustomOptionVisibleAssertPresenceOfFileOption
		$I->comment("Exiting Action Group [assertPresenceOfFileOption] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->comment("Entering Action Group [assertPresenceOfFieldOption] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertPresenceOfFieldOption
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertPresenceOfFieldOptionWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertPresenceOfFieldOption
		$I->seeElement("//span[text()='fifth option" . msq("ProductOptionFieldSecond") . "']/parent::div/parent::div/parent::div//span[text()='Option Title']/parent::label/parent::div/parent::div//input[@class='admin__control-text']"); // stepKey: assertCustomOptionVisibleAssertPresenceOfFieldOption
		$I->comment("Exiting Action Group [assertPresenceOfFieldOption] AdminAssertProductCustomOptionVisibleActionGroup");
		$I->comment("Delete All options and See no more options present on the page");
		$I->comment("Entering Action Group [deleteCustomOptionField] AdminDeleteProductCustomOptionActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabDeleteCustomOptionField
		$I->waitForPageLoad(30); // stepKey: expandContentTabDeleteCustomOptionFieldWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedDeleteCustomOptionField
		$I->click("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(., 'OptionField')]/parent::div/parent::div//button[@class='action-delete']"); // stepKey: clickDeleteCustomOptionDeleteCustomOptionField
		$I->waitForPageLoad(30); // stepKey: clickDeleteCustomOptionDeleteCustomOptionFieldWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCustomOptionField] AdminDeleteProductCustomOptionActionGroup");
		$I->comment("Entering Action Group [deleteCustomOptionFile2] AdminDeleteProductCustomOptionActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabDeleteCustomOptionFile2
		$I->waitForPageLoad(30); // stepKey: expandContentTabDeleteCustomOptionFile2WaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedDeleteCustomOptionFile2
		$I->click("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(., 'fourth option" . msq("ProductOptionFileSecond") . "')]/parent::div/parent::div//button[@class='action-delete']"); // stepKey: clickDeleteCustomOptionDeleteCustomOptionFile2
		$I->waitForPageLoad(30); // stepKey: clickDeleteCustomOptionDeleteCustomOptionFile2WaitForPageLoad
		$I->comment("Exiting Action Group [deleteCustomOptionFile2] AdminDeleteProductCustomOptionActionGroup");
		$I->comment("Entering Action Group [deleteCustomOptionFieldSecond] AdminDeleteProductCustomOptionActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabDeleteCustomOptionFieldSecond
		$I->waitForPageLoad(30); // stepKey: expandContentTabDeleteCustomOptionFieldSecondWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedDeleteCustomOptionFieldSecond
		$I->click("//div[contains(@class, 'fieldset-wrapper-title')]//span[contains(., 'fifth option" . msq("ProductOptionFieldSecond") . "')]/parent::div/parent::div//button[@class='action-delete']"); // stepKey: clickDeleteCustomOptionDeleteCustomOptionFieldSecond
		$I->waitForPageLoad(30); // stepKey: clickDeleteCustomOptionDeleteCustomOptionFieldSecondWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCustomOptionFieldSecond] AdminDeleteProductCustomOptionActionGroup");
		$I->comment("Product successfully saved and it has no options");
		$I->comment("Entering Action Group [saveProductWithoutCustomOptions] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductWithoutCustomOptions
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductWithoutCustomOptions
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWithoutCustomOptionsWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductWithoutCustomOptions
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWithoutCustomOptionsWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductWithoutCustomOptions
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductWithoutCustomOptions
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductWithoutCustomOptions
		$I->comment("Exiting Action Group [saveProductWithoutCustomOptions] SaveProductFormActionGroup");
		$I->comment("Entering Action Group [assertNoCustomOptions] AdminAssertProductHasNoCustomOptionsActionGroup");
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Customizable Options']", "//span[text()='Customizable Options']/parent::strong/parent::*[@data-state-collapsible='closed']", true); // stepKey: expandContentTabAssertNoCustomOptions
		$I->waitForPageLoad(30); // stepKey: expandContentTabAssertNoCustomOptionsWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitCustomizableOptionsTabOpenedAssertNoCustomOptions
		$I->dontSeeElement("[data-index='options'] tbody tr.data-row"); // stepKey: assertNoCustomOptionsAssertNoCustomOptions
		$I->comment("Exiting Action Group [assertNoCustomOptions] AdminAssertProductHasNoCustomOptionsActionGroup");
	}
}
