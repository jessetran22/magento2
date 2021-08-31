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
 * @Title("MC-29653: Saving custom attribute values using UI")
 * @Description("Checks that saved custom attribute values are reflected on the product's edit page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCheckCustomAttributeValuesAfterProductSaveTest.xml<br>")
 * @TestCaseId("MC-29653")
 * @group catalog
 */
class AdminCheckCustomAttributeValuesAfterProductSaveTestCest
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
		$I->comment("Create multi select product attribute");
		$I->createEntity("createMultiSelectProductAttribute", "hook", "productAttributeMultiselectTwoOptions", [], []); // stepKey: createMultiSelectProductAttribute
		$I->comment("Add options to created product attribute");
		$I->createEntity("addFirstOptionToAttribute", "hook", "productAttributeOption1", ["createMultiSelectProductAttribute"], []); // stepKey: addFirstOptionToAttribute
		$I->createEntity("addSecondOptionToAttribute", "hook", "productAttributeOption2", ["createMultiSelectProductAttribute"], []); // stepKey: addSecondOptionToAttribute
		$I->createEntity("addThirdOptionToAttribute", "hook", "productAttributeOption3", ["createMultiSelectProductAttribute"], []); // stepKey: addThirdOptionToAttribute
		$I->comment("Create simple product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Login to Admin page");
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
		$I->comment("Delete created entities");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createMultiSelectProductAttribute", "hook"); // stepKey: deleteMultiSelectProductAttribute
		$I->comment("Logout from Admin page");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Product attributes"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckCustomAttributeValuesAfterProductSaveTest(AcceptanceTester $I)
	{
		$I->comment("Open created product for edit");
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createSimpleProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Add created attribute to the product");
		$I->comment("Entering Action Group [addAttributeToProduct] AddProductAttributeInProductModalActionGroup");
		$I->click("#addAttribute"); // stepKey: addAttributeAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: addAttributeAddAttributeToProductWaitForPageLoad
		$I->conditionalClick(".product_form_product_form_add_attribute_modal .action-clear", ".product_form_product_form_add_attribute_modal .action-clear", true); // stepKey: clearFiltersAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clearFiltersAddAttributeToProductWaitForPageLoad
		$I->click(".product_form_product_form_add_attribute_modal button[data-action='grid-filter-expand']"); // stepKey: clickFiltersAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickFiltersAddAttributeToProductWaitForPageLoad
		$I->fillField(".product_form_product_form_add_attribute_modal input[name='attribute_code']", $I->retrieveEntityField('createMultiSelectProductAttribute', 'attribute_code', 'test')); // stepKey: fillCodeAddAttributeToProduct
		$I->click(".product_form_product_form_add_attribute_modal .admin__data-grid-filters-footer .action-secondary"); // stepKey: clickApplyAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyAddAttributeToProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAddAttributeToProduct
		$I->checkOption(".product_form_product_form_add_attribute_modal .data-grid-checkbox-cell input"); // stepKey: checkAttributeAddAttributeToProduct
		$I->click(".product_form_product_form_add_attribute_modal .page-main-actions .action-primary"); // stepKey: addSelectedAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: addSelectedAddAttributeToProductWaitForPageLoad
		$I->comment("Exiting Action Group [addAttributeToProduct] AddProductAttributeInProductModalActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForAttributeAdded
		$I->comment("Expand 'Attributes' tab");
		$I->comment("Entering Action Group [expandAttributesTab] AdminExpandProductAttributesTabActionGroup");
		$I->scrollTo("//div[@data-index='attributes']"); // stepKey: scrollToAttributesTabExpandAttributesTab
		$I->waitForPageLoad(30); // stepKey: scrollToAttributesTabExpandAttributesTabWaitForPageLoad
		$I->conditionalClick("//div[@data-index='attributes']", "//div[@data-index='attributes']/div[contains(@class, 'admin__collapsible-content _show')]", false); // stepKey: expandAttributesTabExpandAttributesTab
		$I->waitForPageLoad(30); // stepKey: expandAttributesTabExpandAttributesTabWaitForPageLoad
		$I->comment("Exiting Action Group [expandAttributesTab] AdminExpandProductAttributesTabActionGroup");
		$I->comment("Check created attribute presents in the 'Attributes' tab");
		$I->seeElement("div[data-index='" . $I->retrieveEntityField('createMultiSelectProductAttribute', 'attribute_code', 'test') . "'] .admin__field-control select"); // stepKey: assertAttributeIsPresentInTab
		$I->comment("Select attribute options");
		$I->selectOption("div[data-index='" . $I->retrieveEntityField('createMultiSelectProductAttribute', 'attribute_code', 'test') . "'] .admin__field-control select", [$I->retrieveEntityField('addFirstOptionToAttribute', 'option[store_labels][0][label]', 'test'), $I->retrieveEntityField('addThirdOptionToAttribute', 'option[store_labels][0][label]', 'test')]); // stepKey: selectAttributeOptions
		$I->comment("Save product");
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Check attribute options are selected");
		$I->comment("Entering Action Group [expandAttributesTabAfterProductSave] AdminExpandProductAttributesTabActionGroup");
		$I->scrollTo("//div[@data-index='attributes']"); // stepKey: scrollToAttributesTabExpandAttributesTabAfterProductSave
		$I->waitForPageLoad(30); // stepKey: scrollToAttributesTabExpandAttributesTabAfterProductSaveWaitForPageLoad
		$I->conditionalClick("//div[@data-index='attributes']", "//div[@data-index='attributes']/div[contains(@class, 'admin__collapsible-content _show')]", false); // stepKey: expandAttributesTabExpandAttributesTabAfterProductSave
		$I->waitForPageLoad(30); // stepKey: expandAttributesTabExpandAttributesTabAfterProductSaveWaitForPageLoad
		$I->comment("Exiting Action Group [expandAttributesTabAfterProductSave] AdminExpandProductAttributesTabActionGroup");
		$I->seeOptionIsSelected("div[data-index='" . $I->retrieveEntityField('createMultiSelectProductAttribute', 'attribute_code', 'test') . "'] .admin__field-control select", $I->retrieveEntityField('addFirstOptionToAttribute', 'option[store_labels][0][label]', 'test')); // stepKey: assertFirstOptionIsSelected
		$I->seeOptionIsSelected("div[data-index='" . $I->retrieveEntityField('createMultiSelectProductAttribute', 'attribute_code', 'test') . "'] .admin__field-control select", $I->retrieveEntityField('addThirdOptionToAttribute', 'option[store_labels][0][label]', 'test')); // stepKey: assertThirdOptionIsSelected
		$I->comment("Search for the product on Storefront");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [searchProductOnStorefront] StorefrontCheckQuickSearchActionGroup");
		$I->submitForm("#search_mini_form", ['q' => $I->retrieveEntityField('createSimpleProduct', 'name', 'test')]); // stepKey: fillQuickSearchSearchProductOnStorefront
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlSearchProductOnStorefront
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeySearchProductOnStorefront
		$I->seeInTitle("Search results for: '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'"); // stepKey: assertQuickSearchTitleSearchProductOnStorefront
		$I->see("Search results for: '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'", ".page-title span"); // stepKey: assertQuickSearchNameSearchProductOnStorefront
		$I->comment("Exiting Action Group [searchProductOnStorefront] StorefrontCheckQuickSearchActionGroup");
		$I->comment("Assert that attribute values present in layered navigation");
		$I->comment("Entering Action Group [assertFirstAttributeOptionPresence] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createMultiSelectProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertFirstAttributeOptionPresence
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createMultiSelectProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertFirstAttributeOptionPresence
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertFirstAttributeOptionPresence
		$I->see($I->retrieveEntityField('addFirstOptionToAttribute', 'option[store_labels][0][label]', 'test'), ".filter-options-item.active .items li:nth-child(1) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertFirstAttributeOptionPresence
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertFirstAttributeOptionPresenceWaitForPageLoad
		$I->comment("Exiting Action Group [assertFirstAttributeOptionPresence] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->comment("Entering Action Group [assertThirdAttributeOptionPresence] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
		$I->waitForElementVisible("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createMultiSelectProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", 30); // stepKey: waitForAttributeVisibleAssertThirdAttributeOptionPresence
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), '" . $I->retrieveEntityField('createMultiSelectProductAttribute', 'attribute[frontend_labels][0][label]', 'test') . "')]", ".filter-options-item.active .items", false); // stepKey: clickToExpandAttributeAssertThirdAttributeOptionPresence
		$I->waitForElementVisible(".filter-options-item.active .items", 30); // stepKey: waitForAttributeOptionsVisibleAssertThirdAttributeOptionPresence
		$I->see($I->retrieveEntityField('addThirdOptionToAttribute', 'option[store_labels][0][label]', 'test'), ".filter-options-item.active .items li:nth-child(2) a"); // stepKey: assertAttributeOptionInLayeredNavigationAssertThirdAttributeOptionPresence
		$I->waitForPageLoad(30); // stepKey: assertAttributeOptionInLayeredNavigationAssertThirdAttributeOptionPresenceWaitForPageLoad
		$I->comment("Exiting Action Group [assertThirdAttributeOptionPresence] AssertStorefrontAttributeOptionPresentInLayeredNavigationActionGroup");
	}
}
