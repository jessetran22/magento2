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
 * @Title("MC-15845: Samples of Downloadable Products are not accessible, if product is disabled")
 * @Description("Samples of Downloadable Products are not accessible, if product is disabled<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/VerifyDisableDownloadableProductSamplesAreNotAccessibleTest.xml<br>")
 * @TestCaseId("MC-15845")
 * @group downloadable
 * @group catalog
 */
class VerifyDisableDownloadableProductSamplesAreNotAccessibleTestCest
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
		$I->comment("Add downloadable domains");
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add example.com static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create downloadable product");
		$I->createEntity("createProduct", "hook", "DownloadableProductWithOneLink", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Add downloadable link");
		$I->createEntity("addDownloadableLink", "hook", "downloadableLink1", ["createProduct"], []); // stepKey: addDownloadableLink
		$I->comment("Add downloadable sample");
		$I->createEntity("addDownloadableSample", "hook", "DownloadableSample", ["createProduct"], []); // stepKey: addDownloadableSample
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Remove downloadable domains");
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Delete product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteDownloadableProduct
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Admin logout");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Downloadable"})
	 * @Stories({"Downloadable product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function VerifyDisableDownloadableProductSamplesAreNotAccessibleTest(AcceptanceTester $I)
	{
		$I->comment("Open Downloadable product from precondition on Storefront");
		$I->comment("Entering Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenStorefrontProductPage
		$I->comment("Exiting Action Group [openStorefrontProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Sample url is accessible");
		$I->comment("Entering Action Group [seeDownloadableSample] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSeeDownloadableSample
		$I->scrollTo("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('downloadableSampleUrl" . msq("DownloadableSample") . "'))]"); // stepKey: scrollToElementSeeDownloadableSample
		$I->waitForPageLoad(30); // stepKey: scrollToElementSeeDownloadableSampleWaitForPageLoad
		$I->seeElement("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('downloadableSampleUrl" . msq("DownloadableSample") . "'))]"); // stepKey: assertElementSeeDownloadableSample
		$I->waitForPageLoad(30); // stepKey: assertElementSeeDownloadableSampleWaitForPageLoad
		$I->comment("Exiting Action Group [seeDownloadableSample] AssertStorefrontSeeElementActionGroup");
		$I->click("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('downloadableSampleUrl" . msq("DownloadableSample") . "'))]"); // stepKey: clickDownloadableSample
		$I->waitForPageLoad(30); // stepKey: clickDownloadableSampleWaitForPageLoad
		$I->comment("Grab Sample id");
		$I->switchToNextTab(); // stepKey: switchToSampleTab
		$grabDownloadableSampleId = $I->grabFromCurrentUrl("~/sample_id/(\d+)/~"); // stepKey: grabDownloadableSampleId
		$I->closeTab(); // stepKey: closeSampleTab
		$I->comment("Link Sample url is accessible");
		$I->comment("Entering Action Group [seeDownloadableLink] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSeeDownloadableLink
		$I->scrollTo("//label[contains(., 'link-1" . msq("downloadableLink1") . "')]"); // stepKey: scrollToElementSeeDownloadableLink
		$I->waitForPageLoad(30); // stepKey: scrollToElementSeeDownloadableLinkWaitForPageLoad
		$I->seeElement("//label[contains(., 'link-1" . msq("downloadableLink1") . "')]"); // stepKey: assertElementSeeDownloadableLink
		$I->waitForPageLoad(30); // stepKey: assertElementSeeDownloadableLinkWaitForPageLoad
		$I->comment("Exiting Action Group [seeDownloadableLink] AssertStorefrontSeeElementActionGroup");
		$I->click("//label[contains(., 'link-1" . msq("downloadableLink1") . "')]/a[contains(@class, 'sample link')]"); // stepKey: clickDownloadableLinkSample
		$I->comment("Grab Link Sample id");
		$I->switchToNextTab(); // stepKey: switchToLinkSampleTab
		$grabDownloadableLinkId = $I->grabFromCurrentUrl("~/link_id/(\d+)/~"); // stepKey: grabDownloadableLinkId
		$I->closeTab(); // stepKey: closeLinkSampleTab
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Open Downloadable product from precondition");
		$I->comment("Entering Action Group [openProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductOpenProductEditPage
		$I->comment("Exiting Action Group [openProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Change status of product to \"Disable\" and save it");
		$I->comment("Entering Action Group [disableProduct] AdminSetProductDisabledActionGroup");
		$I->conditionalClick("input[name='product[status]']+label", "input[name='product[status]'][value='1']", true); // stepKey: disableProductDisableProduct
		$I->waitForPageLoad(30); // stepKey: disableProductDisableProductWaitForPageLoad
		$I->seeElement("input[name='product[status]'][value='2']"); // stepKey: assertThatProductSetToDisabledDisableProduct
		$I->waitForPageLoad(30); // stepKey: assertThatProductSetToDisabledDisableProductWaitForPageLoad
		$I->comment("Exiting Action Group [disableProduct] AdminSetProductDisabledActionGroup");
		$I->comment("Entering Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductClickSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonClickSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductClickSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductClickSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageClickSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageClickSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationClickSaveProduct
		$I->comment("Exiting Action Group [clickSaveProduct] SaveProductFormActionGroup");
		$I->comment("Assert product is disable on Storefront");
		$I->comment("Entering Action Group [openCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->see("We can't find products matching the selection.", ".message.info.empty>div"); // stepKey: seeEmptyProductMessage
		$I->comment("Navigate to Link Sample url on Storefront");
		$I->comment("Entering Action Group [openDownloadableLinkSample] StorefrontOpenDownloadableLinkActionGroup");
		$I->amOnPage("downloadable/download/linkSample/link_id/{$grabDownloadableLinkId}/"); // stepKey: openDownloadableLinkOpenDownloadableLinkSample
		$I->comment("Exiting Action Group [openDownloadableLinkSample] StorefrontOpenDownloadableLinkActionGroup");
		$I->comment("Link Sample url is not accessible. You are redirected to Home Page");
		$I->seeInCurrentUrl("/"); // stepKey: seeRedirectToHomePage
		$I->comment("Navigate to Sample url on Storefront");
		$I->comment("Entering Action Group [openDownloadableSample] StorefrontOpenDownloadableSampleActionGroup");
		$I->amOnPage("downloadable/download/sample/sample_id/{$grabDownloadableSampleId}/"); // stepKey: openDownloadableSampleOpenDownloadableSample
		$I->comment("Exiting Action Group [openDownloadableSample] StorefrontOpenDownloadableSampleActionGroup");
		$I->comment("Sample url is not accessible. You are redirected to Home Page");
		$I->seeInCurrentUrl("/"); // stepKey: seeHomePage
	}
}
